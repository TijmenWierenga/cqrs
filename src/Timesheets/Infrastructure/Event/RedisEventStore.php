<?php
namespace TijmenWierenga\Project\Timesheets\Infrastructure\Event;

use JMS\Serializer\SerializerInterface;
use NilPortugues\Serializer\Serializer;
use Predis\Client;
use TijmenWierenga\Project\Timesheets\Domain\Event\EventStore;
use TijmenWierenga\Project\Timesheets\Domain\Event\EventStream;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RedisEventStore implements EventStore
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * RedisEventStore constructor.
     * @param Client $client
     * @param Serializer $serializer
     */
    public function __construct(Client $client, Serializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
    }

    /**
     * Adds new event(s) to the event store.
     *
     * @param EventStream $eventStream
     */
    public function append(EventStream $eventStream): void
    {
        foreach ($eventStream->getEvents() as $event)
        {
            $data = $this->serializer->serialize([
                'created_at' => new \DateTimeImmutable(),
                'data' => $this->serializer->serialize($event)
            ]);

            $this->client->rpush(
                'events:' . (string) $eventStream->getId(),
                $data
            );
        }
    }

    /**
     * Gets all events from a specific ID.
     *
     * @param string $id
     * @return EventStream
     */
    public function getEventsFor(string $id): EventStream
    {
        $serializedEvents = $this->client->lrange(
            'events:' . $id,
            0,
            -1
        );

        $eventStream = [];

        foreach ($serializedEvents as $event) {
            $unserialized = $this->serializer->unserialize($event);
            $eventStream[] = $this->serializer->unserialize($unserialized['data']);
        }

        return new EventStream($id, $eventStream);
    }
}

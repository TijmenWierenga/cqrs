<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Event;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use MongoDB\Client;
use NilPortugues\Serializer\Serializer;
use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventId;
use TijmenWierenga\Project\Common\Domain\Event\PersistingEventStore;
use TijmenWierenga\Project\Common\Domain\Exception\ModelNotFoundException;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class MongoPersistingEventStore implements PersistingEventStore
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
     * @var \MongoDB\Collection
     */
    private $collection;

    /**
     * MongoPersistingEventStore constructor.
     * @param Client $client
     * @param Serializer $serializer
     */
    public function __construct(Client $client, Serializer $serializer)
    {
        $this->client = $client;
        $this->serializer = $serializer;
        $this->collection = $this->client->project->events;
    }

    public function store(DomainEvent $domainEvent): void
    {
        $this->collection->insertOne([
            '_id' => (string) $domainEvent->getId(),
            'occurred_on' => $domainEvent->occurredOn(),
            'body' => $this->serializer->serialize($domainEvent),
            'stored_at' => microtime(true)
        ]);
    }

    public function getAllEventsSince(DomainEventId $domainEventId): Collection
    {
        $lastInsertedDocument = $this->collection->findOne(['_id' => (string) $domainEventId]);

        if (! $lastInsertedDocument) {
            throw ModelNotFoundException::byId(DomainEvent::class, $domainEventId);
        }

        $nonHandledEvents = $this->collection->find(['stored_at' => ['$gt' => $lastInsertedDocument->stored_at]]);

        $events = new ArrayCollection();
        foreach ($nonHandledEvents as $event) {
            $events->add($this->serializer->unserialize($event->body));
        }

        return $events;
    }
}

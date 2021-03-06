<?php
namespace TijmenWierenga\Project\Account\Infrastructure\Projection\Mongo\User;

use MongoDB\Client;
use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Account\Domain\Model\User\UserWasCreated;
use TijmenWierenga\Project\Common\Domain\Projection\Projection;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserWasCreatedProjection implements Projection
{
    /**
     * @var Client
     */
    private $client;

    /**
     * UserWasCreatedProjection constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Returns the event the projection is listening for
     *
     * @return string
     */
    public function listensTo(): string
    {
        return UserWasCreated::class;
    }

    /**
     * Projects a given event to the read model
     *
     * @param UserWasCreated $event
     */
    public function project(DomainEvent $event): void
    {
        $collection = $this->client->project->users;

        $collection->insertOne([
            '_id' => (string) $event->getUserId(),
            'first_name' => $event->getFirstName(),
            'last_name' => $event->getLastName(),
            'email' => $event->getEmail(),
            'password' => $event->getPassword()
        ]);
    }
}

<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Event\Subscriber;

use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventSubscriber;
use TijmenWierenga\Project\Common\Domain\Event\PersistingEventStore;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class PersistDomainEventSubscriber implements DomainEventSubscriber
{
    /**
     * @var PersistingEventStore
     */
    private $persistingEventStore;

    /**
     * PersistDomainEventSubscriber constructor.
     * @param PersistingEventStore $persistingEventStore
     */
    public function __construct(PersistingEventStore $persistingEventStore)
    {
        $this->persistingEventStore = $persistingEventStore;
    }

    /**
     * Handles a domain event
     *
     * @param DomainEvent $domainEvent
     */
    public function handle(DomainEvent $domainEvent): void
    {
        $this->persistingEventStore->store($domainEvent);
    }

    /**
     * Checks whether the subscriber is subscribed to an event
     *
     * @param DomainEvent $domainEvent
     * @return bool
     */
    public function isSubscribedTo(DomainEvent $domainEvent): bool
    {
        return true;
    }
}

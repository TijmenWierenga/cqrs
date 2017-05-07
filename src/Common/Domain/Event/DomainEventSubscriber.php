<?php
namespace TijmenWierenga\Project\Common\Domain\Event;

interface DomainEventSubscriber
{
    /**
     * Handles a domain event
     *
     * @param DomainEvent $domainEvent
     */
    public function handle(DomainEvent $domainEvent): void;

    /**
     * Checks whether the subscriber is subscribed to an event
     *
     * @param DomainEvent $domainEvent
     * @return bool
     */
    public function isSubscribedTo(DomainEvent $domainEvent): bool;
}

<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Event\Subscriber;

use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventSubscriber;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class LogEventSubscriber implements DomainEventSubscriber
{
    /**
     * Handles a domain event
     *
     * @param DomainEvent $domainEvent
     */
    public function handle(DomainEvent $domainEvent): void
    {
        dump('Handled: ' . get_class($domainEvent) . PHP_EOL);
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

<?php
namespace TijmenWierenga\Project\Common\Domain\Event;

use Doctrine\Common\Collections\Collection;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
interface PersistingEventStore
{
    /**
     * @param DomainEvent $domainEvent
     */
    public function store(DomainEvent $domainEvent): void;

    /**
     * @param DomainEventId $domainEventId
     * @return Collection
     */
    public function getAllEventsSince(DomainEventId $domainEventId): Collection;
}

<?php

namespace TijmenWierenga\Project\Common\Domain\Event;

use DateTimeImmutable;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
interface DomainEvent
{
    /**
     * Returns the date and time when the event occurred.
     *
     * @return DateTimeImmutable
     */
    public function occurredOn(): DateTimeImmutable;

    /**
     * Returns the unique ID of the event.
     *
     * @return DomainEventId
     */
    public function getId(): DomainEventId;
}

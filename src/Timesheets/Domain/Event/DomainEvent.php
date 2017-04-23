<?php

namespace TijmenWierenga\Project\Timesheets\Domain\Event;

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
}

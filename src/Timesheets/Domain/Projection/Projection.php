<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Projection;

use TijmenWierenga\Project\Timesheets\Domain\Event\DomainEvent;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
interface Projection
{
    /**
     * Returns the event the projection is listening for
     *
     * @return string
     */
    public function listensTo(): string;

    /**
     * Projects a given event to the read model
     *
     * @param DomainEvent $event
     */
    public function project(DomainEvent $event): void;
}

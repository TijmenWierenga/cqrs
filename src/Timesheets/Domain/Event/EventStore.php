<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Event;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
interface EventStore
{
    /**
     * Adds new event(s) to the event store.
     *
     * @param EventStream $eventStream
     */
    public function append(EventStream $eventStream): void;

    /**
     * Gets all events from a specific ID.
     *
     * @param string $id
     * @return EventStream
     */
    public function getEventsFor(string $id): EventStream;
}

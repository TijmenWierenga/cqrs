<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Model\Aggregate;

use TijmenWierenga\Project\Timesheets\Domain\Event\EventStream;

interface EventSourcedAggregateRoot
{
    /**
     * @param EventStream $events
     * @return EventSourcedAggregateRoot
     */
    public static function reconstitute(EventStream $events);
}

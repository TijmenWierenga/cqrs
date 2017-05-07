<?php
namespace TijmenWierenga\Project\Common\Domain\Model\Aggregate;

use TijmenWierenga\Project\Common\Domain\Event\EventStream;

interface EventSourcedAggregateRoot
{
    /**
     * @param EventStream $events
     * @return EventSourcedAggregateRoot
     */
    public static function reconstitute(EventStream $events);
}

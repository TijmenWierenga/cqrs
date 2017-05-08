<?php

namespace TijmenWierenga\Project\Common\Domain\Model\Aggregate;

use ReflectionClass;
use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventPublisher;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class AggregateRoot
{
    /**
     * @var array  Recorded events during request
     */
    protected $recordedEvents = [];

    /**
     * @param DomainEvent $event
     */
    protected function apply(DomainEvent $event): void
    {
        $this->record($event);
        $this->publish($event);

        $eventShortName = (new ReflectionClass($event))->getShortName();

        $handler = "apply{$eventShortName}";

        $this->$handler($event);
    }

    /**
     * @param DomainEvent $event
     */
    protected function record(DomainEvent $event): void
    {
        $this->recordedEvents[] = $event;
    }

    /**
     * @return array
     */
    public function recordedEvents(): array
    {
        return $this->recordedEvents;
    }

    /**
     * Clears all recorded events
     */
    public function clearEvents(): void
    {
        $this->recordedEvents = [];
    }

    private function publish(DomainEvent $event)
    {
        DomainEventPublisher::instance()->publish($event);
    }
}

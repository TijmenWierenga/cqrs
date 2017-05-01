<?php
namespace TijmenWierenga\Project\Timesheets\Infrastructure\Projection;

use TijmenWierenga\Project\Timesheets\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Timesheets\Domain\Event\EventStream;
use TijmenWierenga\Project\Timesheets\Domain\Projection\Projection;
use TijmenWierenga\Project\Timesheets\Domain\Projection\ProjectionException;
use TijmenWierenga\Project\Timesheets\Domain\Projection\Projector as ProjectorInterface;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class Projector implements ProjectorInterface
{
    /**
     * @var array
     */
    private $projections;

    /**
     * Registers listeners to the projector
     *
     * @param iterable $projectors
     */
    public function register(iterable $projectors): void
    {
        /** @var Projection $projection */
        foreach ($projectors as $projection) {
            $this->projections[$projection->listensTo()] = $projection;
        }
    }

    /**
     * Projects events to the read model
     *
     * @param EventStream $events
     */
    public function project(EventStream $events): void
    {
        foreach ($events->getEvents() as $event) {
            $projector = $this->getProjectorForEvent($event);
            $projector->project($event);
        }
    }

    /**
     * @param DomainEvent $event
     * @throws ProjectionException
     * @return Projection
     */
    private function getProjectorForEvent(DomainEvent $event): Projection
    {
        if (! array_key_exists(get_class($event), $this->projections)) {
            throw ProjectionException::noProjectionConfiguredForEvent(get_class($event));
        }

        return $this->projections[get_class($event)];
    }
}

<?php
namespace TijmenWierenga\Project\Shared\Domain\Projection;


use TijmenWierenga\Project\Shared\Domain\Event\EventStream;

interface Projector
{
    /**
     * Registers listeners to the projector
     *
     * @param iterable $projectors
     */
    public function register(iterable $projectors): void;

    /**
     * Projects events to the read model
     *
     * @param EventStream $events
     */
    public function project(EventStream $events): void;
}
<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Event;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class EventStream 
{
    /**
     * @var array
     */
    private $events;

    /**
     * @var string
     */
    private $id;

    /**
     * EventStream constructor.
     * @param string $id
     * @param array $events
     */
    public function __construct(string $id, array $events)
    {
        $this->events = $events;
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}

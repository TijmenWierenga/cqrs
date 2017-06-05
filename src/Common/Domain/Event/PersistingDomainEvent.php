<?php
namespace TijmenWierenga\Project\Common\Domain\Event;

use DateTimeImmutable;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
abstract class PersistingDomainEvent implements DomainEvent
{
    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;

    /**
     * @var DomainEventId
     */
    private $eventId;

    /**
     * AbstractDomainEvent constructor.
     */
    public function __construct()
    {
        $this->occurredOn = new DateTimeImmutable();
        $this->eventId = DomainEventId::new();
    }

    /**
     * @return DateTimeImmutable
     */
    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    /**
     * @return DomainEventId
     */
    public function getId(): DomainEventId
    {
        return $this->eventId;
    }
}

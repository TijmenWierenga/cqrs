<?php

namespace TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject;

use DateInterval;
use DateTimeImmutable;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class TimeFrame
{
    /**
     * @var DateTimeImmutable
     */
    private $start;
    /**
     * @var DateTimeImmutable
     */
    private $end;

    /**
     * TimeFrame constructor.
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     */
    private function __construct(DateTimeImmutable $start, DateTimeImmutable $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    /**
     * @param DateTimeImmutable $start
     * @param DateTimeImmutable $end
     * @return TimeFrame
     */
    public static function new(DateTimeImmutable $start, DateTimeImmutable $end): self
    {
        return new self($start, $end);
    }

    /**
     * @return DateTimeImmutable
     */
    public function start(): DateTimeImmutable
    {
        return $this->start;
    }

    /**
     * @return DateTimeImmutable
     */
    public function end(): DateTimeImmutable
    {
        return $this->end;
    }

    /**
     * @return DateInterval
     */
    public function duration(): DateInterval
    {
        return $this->end->diff($this->start);
    }
}

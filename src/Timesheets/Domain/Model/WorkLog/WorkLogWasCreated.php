<?php

namespace TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog;

use TijmenWierenga\Project\Timesheets\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class WorkLogWasCreated implements DomainEvent
{
    /**
     * @var TimeFrame
     */
    private $timeFrame;

    /**
     * WorkLogWasCreated constructor.
     * @param TimeFrame $timeFrame
     */
    public function __construct(TimeFrame $timeFrame)
    {
        $this->timeFrame = $timeFrame;
    }

    /**
     * @return TimeFrame
     */
    public function getTimeFrame(): TimeFrame
    {
        return $this->timeFrame;
    }
}

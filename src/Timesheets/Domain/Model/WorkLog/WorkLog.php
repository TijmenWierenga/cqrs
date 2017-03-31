<?php

namespace TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog;

use TijmenWierenga\Project\Timesheets\Domain\Model\Aggregate\AggregateRoot;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class WorkLog extends AggregateRoot
{
    /**
     * @var TimeFrame
     */
    private $timeFrame;

    /**
     * WorkLog constructor.
     */
    private function __construct()
    {
    }

    /**
     * @param TimeFrame $timeFrame
     * @return WorkLog
     */
    public static function new(TimeFrame $timeFrame): self
    {
        $workLog = new self();

        $workLog->apply(new WorkLogWasCreated($timeFrame));

        return $workLog;
    }

    /**
     * @param WorkLogWasCreated $event
     */
    protected function applyWorkLogWasCreated(WorkLogWasCreated $event): void
    {
        $this->timeFrame = $event->getTimeFrame();
    }

    /**
     * @return TimeFrame
     */
    public function getTimeFrame(): TimeFrame
    {
        return $this->timeFrame;
    }
}

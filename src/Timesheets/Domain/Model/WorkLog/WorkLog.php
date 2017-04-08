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
     * @var WorkLogId
     */
    private $workLogId;

    /**
     * WorkLog constructor.
     * @param WorkLogId $workLogId
     */
    private function __construct(WorkLogId $workLogId)
    {
        $this->workLogId = $workLogId;
    }

    /**
     * @param WorkLogId $workLogId
     * @param TimeFrame $timeFrame
     * @return WorkLog
     */
    public static function new(WorkLogId $workLogId, TimeFrame $timeFrame): self
    {
        $workLog = new self($workLogId);

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

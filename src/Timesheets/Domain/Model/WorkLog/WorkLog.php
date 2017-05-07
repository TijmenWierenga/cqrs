<?php

namespace TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog;

use TijmenWierenga\Project\Common\Domain\Event\EventStream;
use TijmenWierenga\Project\Common\Domain\Model\Aggregate\AggregateRoot;
use TijmenWierenga\Project\Common\Domain\Model\Aggregate\EventSourcedAggregateRoot;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class WorkLog extends AggregateRoot implements EventSourcedAggregateRoot
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
     * @var UserId
     */
    private $userId;

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
     * @param UserId $userId
     * @param TimeFrame $timeFrame
     * @return WorkLog
     */
    public static function new(WorkLogId $workLogId, UserId $userId, TimeFrame $timeFrame): self
    {
        $workLog = new self($workLogId);

        $workLog->apply(new WorkLogWasCreated($workLogId, $userId, $timeFrame));

        return $workLog;
    }

    /**
     * @param EventStream $history
     * @return WorkLog
     */
    public static function reconstitute(EventStream $history)
    {
        $workLog = new static(WorkLogId::fromString($history->getId()));

        foreach ($history->getEvents() as $event) {
            $workLog->apply($event);
        }

        return $workLog;
    }

    /**
     * @param WorkLogWasCreated $event
     */
    protected function applyWorkLogWasCreated(WorkLogWasCreated $event): void
    {
        $this->timeFrame = $event->getTimeFrame();
        $this->userId = $event->getUserId();
    }

    /**
     * @return TimeFrame
     */
    public function getTimeFrame(): TimeFrame
    {
        return $this->timeFrame;
    }

    /**
     * @return WorkLogId
     */
    public function getWorkLogId(): WorkLogId
    {
        return $this->workLogId;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }
}

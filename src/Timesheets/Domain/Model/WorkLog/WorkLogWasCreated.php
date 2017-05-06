<?php

namespace TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog;

use DateTimeImmutable;
use TijmenWierenga\Project\Shared\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
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
     * @var WorkLogId
     */
    private $workLogId;

    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;
    /**
     * @var UserId
     */
    private $userId;

    /**
     * WorkLogWasCreated constructor.
     * @param WorkLogId $workLogId
     * @param UserId $userId
     * @param TimeFrame $timeFrame
     */
    public function __construct(WorkLogId $workLogId, UserId $userId, TimeFrame $timeFrame)
    {
        $this->timeFrame = $timeFrame;
        $this->workLogId = $workLogId;
        $this->userId = $userId;
        $this->occurredOn = new DateTimeImmutable();
    }

    /**
     * @return WorkLogId
     */
    public function getWorkLogId(): WorkLogId
    {
        return $this->workLogId;
    }

    /**
     * @return TimeFrame
     */
    public function getTimeFrame(): TimeFrame
    {
        return $this->timeFrame;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * Returns the date and time when the event occurred.
     *
     * @return DateTimeImmutable
     */
    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }
}

<?php

namespace TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog;

use DateTimeImmutable;
use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Common\Domain\Event\PersistingDomainEvent;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class WorkLogWasCreated extends PersistingDomainEvent implements DomainEvent
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
     * WorkLogWasCreated constructor.
     * @param WorkLogId $workLogId
     * @param UserId $userId
     * @param TimeFrame $timeFrame
     */
    public function __construct(WorkLogId $workLogId, UserId $userId, TimeFrame $timeFrame)
    {
        parent::__construct();
        $this->timeFrame = $timeFrame;
        $this->workLogId = $workLogId;
        $this->userId = $userId;
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
}

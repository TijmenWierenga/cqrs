<?php
namespace TijmenWierenga\Project\Timesheets\Infrastructure\Repository\WorkLog;

use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLog;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogId;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogRepository;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class EventSourcedWorkLogRepository implements WorkLogRepository
{
    /**
     * Finds a WorkLog by WorkLogId
     *
     * @param WorkLogId $workLogId
     * @return WorkLog
     */
    public function find(WorkLogId $workLogId): WorkLog
    {
        // TODO: Implement find() method.
    }

    /**
     * Stores a WorkLog.
     *
     * @param WorkLog $workLog
     */
    public function save(WorkLog $workLog): void
    {
        // TODO: Implement save() method.
    }
}

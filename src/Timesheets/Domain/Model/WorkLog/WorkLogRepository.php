<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
interface WorkLogRepository
{
    /**
     * Finds a WorkLog by WorkLogId
     *
     * @param WorkLogId $workLogId
     * @return WorkLog
     */
    public function find(WorkLogId $workLogId): WorkLog;

    /**
     * Stores a WorkLog.
     *
     * @param WorkLog $workLog
     */
    public function save(WorkLog $workLog): void;
}

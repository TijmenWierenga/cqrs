<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
interface WorkLogRepository
{
    /**
     * Stores a WorkLog.
     *
     * @param WorkLog $workLog
     */
    public function save(WorkLog $workLog): void;
}

<?php

namespace TijmenWierenga\Project\Tests\Timesheets\Domain\Model\WorkLog;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLog;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogWasCreated;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class WorkLogTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_new_work_log()
    {
        $start = new DateTimeImmutable("2017-03-31T08:00:00");
        $end = new DateTimeImmutable("2017-03-31T17:00:00");
        $timeFrame = TimeFrame::new($start, $end);

        $workLog = WorkLog::new($timeFrame);

        $this->assertInstanceOf(WorkLog::class, $workLog);
        $this->assertSame($timeFrame, $workLog->getTimeFrame());

        return $workLog;
    }

    /**
     * @test
     * @depends it_creates_a_new_work_log
     */
    public function it_records_that_a_new_work_log_was_created(WorkLog $workLog)
    {
        $recordedEvents = $workLog->recordedEvents();

        $this->assertInstanceOf(WorkLogWasCreated::class, reset($recordedEvents));
    }
}

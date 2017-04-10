<?php

namespace TijmenWierenga\Project\Tests\Timesheets\Domain\Model\WorkLog;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Timesheets\Domain\Event\EventStream;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLog;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogId;
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

        $workLog = WorkLog::new(WorkLogId::new(), $timeFrame);

        $this->assertInstanceOf(WorkLog::class, $workLog);
        $this->assertSame($timeFrame, $workLog->getTimeFrame());

        return $workLog;
    }

    /**
     * @test
     * @depends it_creates_a_new_work_log
     * @param WorkLog $workLog
     */
    public function it_records_that_a_new_work_log_was_created(WorkLog $workLog)
    {
        $recordedEvents = $workLog->recordedEvents();

        $this->assertInstanceOf(WorkLogWasCreated::class, reset($recordedEvents));
    }

    /**
     * @test
     */
    public function a_work_log_can_be_reconstituted()
    {
        $workLogId = WorkLogId::new();
        $timeFrame = TimeFrame::new(
            new DateTimeImmutable("2017-04-10T08:00:00"),
            new DateTimeImmutable("2017-04-10T14:00:00")
        );
        $events = [
            new WorkLogWasCreated($timeFrame)
        ];

    	$history = new EventStream((string) $workLogId, $events);

    	$workLog = WorkLog::reconstitute($history);
    	$this->assertEquals($events[0], $workLog->recordedEvents()[0]);
    	$this->assertEquals($workLogId, $workLog->getWorkLogId());
    	$this->assertEquals($timeFrame, $workLog->getTimeFrame());
    }
}

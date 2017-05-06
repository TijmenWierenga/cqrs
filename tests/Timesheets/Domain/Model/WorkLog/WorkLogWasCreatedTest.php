<?php
namespace TijmenWierenga\Project\Tests\Timesheets\Domain\Model\WorkLog;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogId;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogWasCreated;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class WorkLogWasCreatedTest extends TestCase
{
    /**
     * @test
     */
    public function a_work_log_was_created_event_has_a_timestamp()
    {
    	$event = new WorkLogWasCreated(WorkLogId::new(), UserId::new(), TimeFrame::new(
            new DateTimeImmutable("2017-03-31T08:00:00"),
            new DateTimeImmutable("2017-03-31T17:00:00")
        ));

    	$this->assertInstanceOf(DateTimeImmutable::class, $event->occurredOn());
    }
}

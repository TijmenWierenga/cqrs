<?php
namespace TijmenWierenga\Project\Tests\Timesheets\Infrastructure\Repository;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TijmenWierenga\Project\Timesheets\Domain\Event\EventStore;
use TijmenWierenga\Project\Timesheets\Domain\Event\EventStream;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLog;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogId;
use TijmenWierenga\Project\Timesheets\Domain\Exception\ModelNotFoundException;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogWasCreated;
use TijmenWierenga\Project\Timesheets\Infrastructure\Repository\WorkLog\EventSourcedWorkLogRepository;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class EventSourcedWorkLogRepositoryTest extends TestCase
{
    /**
     * @var EventStore|PHPUnit_Framework_MockObject_MockObject
     */
    private $eventStore;

    /**
     * @var EventSourcedWorkLogRepository
     */
    private $repository;

    public function setUp()
    {
        $this->eventStore = $this->getMockBuilder(EventStore::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->repository = new EventSourcedWorkLogRepository($this->eventStore);
    }

    /**
     * @test
     */
    public function it_throws_a_not_found_exception_when_work_log_does_not_exist()
    {
        $workLogId = WorkLogId::new();

        $this->expectException(ModelNotFoundException::class);
        $this->expectExceptionMessage(
            "TijmenWierenga\\Project\\Timesheets\\Domain\\Model\\WorkLog\\WorkLog\\{$workLogId} could not be found"
        );

        $this->eventStore->expects($this->once())
            ->method('getEventsFor')
            ->with((string) $workLogId)
            ->willReturn(new EventStream($workLogId, []));

    	$this->repository->find($workLogId);
    }

    /**
     * @test
     */
    public function it_finds_and_returns_a_work_log()
    {
    	$workLogId = WorkLogId::new();

        $this->eventStore->expects($this->once())
            ->method('getEventsFor')
            ->with((string) $workLogId)
            ->willReturn(new EventStream($workLogId, [
                new WorkLogWasCreated($workLogId, UserId::new(), TimeFrame::new(
                    new DateTimeImmutable("2017-04-10T08:00:00"),
                    new DateTimeImmutable("2017-04-10T14:00:00")
                ))
            ]));

        $workLog = $this->repository->find($workLogId);

        $this->assertEquals($workLogId, $workLog->getWorkLogId());
    }

    /**
     * @test
     */
    public function it_stores_a_work_log()
    {
    	$workLog = WorkLog::new(WorkLogId::new(), UserId::new(), TimeFrame::new(
            new DateTimeImmutable("2017-04-10T08:00:00"),
            new DateTimeImmutable("2017-04-10T14:00:00")
        ));

    	$this->eventStore->expects($this->once())
            ->method('append');

    	$this->repository->save($workLog);
    }
}

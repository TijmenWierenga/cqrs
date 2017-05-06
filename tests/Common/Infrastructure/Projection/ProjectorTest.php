<?php
namespace TijmenWierenga\Project\Tests\Common\Infrastructure\Projection;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Common\Domain\Event\EventStream;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Account\Domain\Model\User\UserWasCreated;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogId;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogWasCreated;
use TijmenWierenga\Project\Common\Domain\Projection\Projection;
use TijmenWierenga\Project\Common\Domain\Projection\ProjectionException;
use TijmenWierenga\Project\Common\Infrastructure\Projection\Projector;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class ProjectorTest extends TestCase
{
    /**
     * @test
     */
    public function it_projects_events()
    {
    	$projector = new Projector();

    	$projections = [
    	    $projection = $this->getMockBuilder(Projection::class)->getMock()
        ];

        $userId = UserId::new();
    	$event = new UserWasCreated($userId, 'Tijmen', 'Wierenga');

    	$projection->expects($this->once())
            ->method('listensTo')
            ->willReturn(UserWasCreated::class);

    	$projection->expects($this->once())
            ->method('project')
            ->with($event);

    	$projector->register($projections);

    	$registeredProjections = new \ReflectionProperty($projector, 'projections');
    	$registeredProjections->setAccessible(true);
    	$listeners = $registeredProjections->getValue($projector);
    	$registeredProjections->setAccessible(false);

    	$this->assertEquals($projection, $listeners[UserWasCreated::class]);

    	$projector->project(new EventStream($userId, [
    	    $event
        ]));

    	return $projector;
    }

    /**
     * @test
     * @depends it_projects_events
     * @param Projector $projector
     */
    public function it_throws_an_exception_when_trying_to_project_an_event_without_a_handler(Projector $projector)
    {
        $this->expectException(ProjectionException::class);

        $workLogId = WorkLogId::new();
        $eventStream = new EventStream($workLogId, [
            new WorkLogWasCreated($workLogId, UserId::new(), Timeframe::new(
                new DateTimeImmutable("2017-04-10T08:00:00"),
                new DateTimeImmutable("2017-04-10T14:00:00")
            ))
        ]);

    	$projector->project($eventStream);
    }
}

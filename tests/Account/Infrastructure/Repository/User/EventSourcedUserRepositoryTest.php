<?php
namespace TijmenWierenga\Project\Tests\Account\Infrastructure\Repository\User;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Account\Infrastructure\Repository\User\EventSourcedUserRepository;
use TijmenWierenga\Project\Common\Domain\Event\EventStore;
use TijmenWierenga\Project\Common\Domain\Event\EventStream;
use TijmenWierenga\Project\Common\Domain\Projection\Projector;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class EventSourcedUserRepositoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_saves_a_user_to_the_event_store_and_projects_to_the_read_model()
    {
        /** @var EventStore|PHPUnit_Framework_MockObject_MockObject $eventStore */
        $eventStore = $this->getMockBuilder(EventStore::class)->getMock();
        /** @var Projector|PHPUnit_Framework_MockObject_MockObject $projector */
        $projector = $this->getMockBuilder(Projector::class)->getMock();

        $eventStore->expects($this->once())
            ->method('append')
            ->with($this->isInstanceOf(EventStream::class));

        $projector->expects($this->once())
            ->method('project')
            ->with($this->isInstanceOf(EventStream::class));

    	$repository = new EventSourcedUserRepository($eventStore, $projector);
    	$repository->save(User::new(UserId::new(), 'John', 'Doe'));
    }
}

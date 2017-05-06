<?php
namespace TijmenWierenga\Project\Account\Infrastructure\Repository\User;

use TijmenWierenga\Project\Common\Domain\Event\EventStore;
use TijmenWierenga\Project\Common\Domain\Event\EventStream;
use TijmenWierenga\Project\Common\Domain\Exception\ModelNotFoundException;
use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Account\Domain\Model\User\UserRepository;
use TijmenWierenga\Project\Timesheets\Domain\Projection\Projector;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class EventSourcedUserRepository implements UserRepository
{
    /**
     * @var EventStore
     */
    private $eventStore;
    /**
     * @var Projector
     */
    private $projector;

    /**
     * EventSourcedUserRepository constructor.
     * @param EventStore $eventStore
     * @param Projector $projector
     */
    public function __construct(EventStore $eventStore, Projector $projector)
    {
        $this->eventStore = $eventStore;
        $this->projector = $projector;
    }

    /**
     * @param UserId $userId
     * @throws ModelNotFoundException
     * @return User
     */
    public function find(UserId $userId): User
    {
        $eventStream = $this->eventStore->getEventsFor($userId);

        if (! count($eventStream->getEvents())) throw new ModelNotFoundException(User::class, $userId);

        return User::reconstitute($eventStream);
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        $events = new EventStream($user->getUserId(), $user->recordedEvents());

        $this->eventStore->append($events);
        $user->clearEvents();

        $this->projector->project($events);
    }
}

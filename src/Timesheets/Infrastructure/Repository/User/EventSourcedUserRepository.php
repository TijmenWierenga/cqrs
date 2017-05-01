<?php
namespace TijmenWierenga\Project\Timesheets\Infrastructure\Repository\User;

use TijmenWierenga\Project\Timesheets\Domain\Event\EventStore;
use TijmenWierenga\Project\Timesheets\Domain\Event\EventStream;
use TijmenWierenga\Project\Timesheets\Domain\Exception\ModelNotFoundException;
use TijmenWierenga\Project\Timesheets\Domain\Model\User\User;
use TijmenWierenga\Project\Timesheets\Domain\Model\User\UserId;
use TijmenWierenga\Project\Timesheets\Domain\Model\User\UserRepository;
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

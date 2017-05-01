<?php
namespace TijmenWierenga\Project\Timesheets\Infrastructure\Repository\User;

use TijmenWierenga\Project\Timesheets\Domain\Event\EventStore;
use TijmenWierenga\Project\Timesheets\Domain\Exception\ModelNotFoundException;
use TijmenWierenga\Project\Timesheets\Domain\Model\User\User;
use TijmenWierenga\Project\Timesheets\Domain\Model\User\UserId;
use TijmenWierenga\Project\Timesheets\Domain\Model\User\UserRepository;

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
     * EventSourcedUserRepository constructor.
     * @param EventStore $eventStore
     */
    public function __construct(EventStore $eventStore)
    {
        $this->eventStore = $eventStore;
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
        // TODO: Implement save() method.
    }
}

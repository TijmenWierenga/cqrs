<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;
use TijmenWierenga\Project\Common\Domain\Event\EventStream;
use TijmenWierenga\Project\Common\Domain\Model\Aggregate\AggregateRoot;
use TijmenWierenga\Project\Common\Domain\Model\Aggregate\EventSourcedAggregateRoot;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class User extends AggregateRoot implements EventSourcedAggregateRoot
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var Email
     */
    private $email;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * User constructor.
     * @param UserId $userId
     */
    private function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param UserId $userId
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @return User
     */
    public static function new(UserId $userId, string $email, string $firstName, string $lastName)
    {
        $user = new self($userId);

        $user->apply(new UserWasCreated($userId, $email, $firstName, $lastName));

        return $user;
    }

    /**
     * @return UserId
     */
    public function getUserId(): UserId
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->firstName = $event->getFirstName();
        $this->lastName = $event->getLastName();
        $this->email = new Email($event->getEmail());
    }

    /**
     * @param EventStream $history
     * @return EventSourcedAggregateRoot
     */
    public static function reconstitute(EventStream $history)
    {
        $user = new static(UserId::fromString($history->getId()));

        foreach ($history->getEvents() as $event) {
            $user->apply($event);
        }

        return $user;
    }
}

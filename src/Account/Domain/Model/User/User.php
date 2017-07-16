<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use JsonSerializable;
use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;
use TijmenWierenga\Project\Common\Domain\Event\EventStream;
use TijmenWierenga\Project\Common\Domain\Model\Aggregate\AggregateRoot;
use TijmenWierenga\Project\Common\Domain\Model\Aggregate\EventSourcedAggregateRoot;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class User extends AggregateRoot implements EventSourcedAggregateRoot, JsonSerializable
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
     * @var string
     */
    private $password;

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
     * @param string $password
     * @return User
     */
    public static function new(UserId $userId, string $email, string $firstName, string $lastName, string $password)
    {
        $user = new self($userId);

        $user->apply(new UserWasCreated($userId, $email, $firstName, $lastName, $password));

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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->firstName = $event->getFirstName();
        $this->lastName = $event->getLastName();
        $this->email = new Email($event->getEmail());
        $this->password = $event->getPassword();
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

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            "id" => (string) $this->getUserId(),
            "first_name" => $this->getFirstName(),
            "last_name" => $this->getLastName(),
            "email" => (string) $this->getEmail()
        ];
    }
}

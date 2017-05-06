<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use DateTimeImmutable;
use TijmenWierenga\Project\Timesheets\Domain\Event\DomainEvent;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserWasCreated implements DomainEvent
{
    /**
     * @var DateTimeImmutable
     */
    private $occurredOn;

    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * UserWasCreated constructor.
     * @param UserId $userId
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(UserId $userId, string $firstName, string $lastName)
    {
        $this->occurredOn = new DateTimeImmutable();
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
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
}

<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use DateTimeImmutable;
use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;
use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;

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
     * @var string
     */
    private $email;

    /**
     * UserWasCreated constructor.
     * @param UserId $userId
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     */
    public function __construct(UserId $userId, string $email, string $firstName, string $lastName)
    {
        $this->occurredOn = new DateTimeImmutable();
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
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

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}

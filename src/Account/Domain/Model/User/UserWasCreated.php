<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use DateTimeImmutable;
use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;
use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventId;
use TijmenWierenga\Project\Common\Domain\Event\PersistingDomainEvent;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserWasCreated extends PersistingDomainEvent implements DomainEvent
{
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
     * @var string
     */
    private $password;

    /**
     * UserWasCreated constructor.
     * @param UserId $userId
     * @param string $email
     * @param string $firstName
     * @param string $lastName
     * @param string $password
     */
    public function __construct(UserId $userId, string $email, string $firstName, string $lastName, string $password)
    {
        parent::__construct();
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}

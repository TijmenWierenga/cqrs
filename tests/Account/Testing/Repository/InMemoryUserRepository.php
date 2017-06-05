<?php
namespace TijmenWierenga\Project\Tests\Account\Testing\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Account\Domain\Model\User\UserRepository;
use TijmenWierenga\Project\Common\Domain\Exception\ModelNotFoundException;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class InMemoryUserRepository implements UserRepository
{
    /**
     * @var ArrayCollection
     */
    private $users;

    /**
     * InMemoryUserRepository constructor.
     * @param User[]|array $users
     */
    public function __construct(array $users = [])
    {
        $this->users = new ArrayCollection($users);
    }

    /**
     * @param UserId $userId
     * @throws ModelNotFoundException
     * @return User
     */
    public function find(UserId $userId): User
    {
        $result = $this->users->filter(function (User $user) use ($userId) {
           return $user->getUserId() === $userId;
        });

        return $result->first();
    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $this->users->add($user);

        return $user;
    }
}

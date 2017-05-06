<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use TijmenWierenga\Project\Shared\Domain\Exception\ModelNotFoundException;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
interface UserRepository
{
    /**
     * @param UserId $userId
     * @throws ModelNotFoundException
     * @return User
     */
    public function find(UserId $userId): User;

    /**
     * @param User $user
     */
    public function save(User $user): void;
}

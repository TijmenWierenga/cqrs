<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Model\User;

use TijmenWierenga\Project\Timesheets\Domain\Exception\ModelNotFoundException;

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

<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;

interface UserDataStore
{
    /**
     * Finds a user by Id
     *
     * @param UserId $userId
     * @return mixed
     */
    public function find(UserId $userId);

    /**
     * Checks if an email address is already registered for a user
     *
     * @param Email $email
     * @return bool
     */
    public function emailAlreadyExists(Email $email): bool;
}

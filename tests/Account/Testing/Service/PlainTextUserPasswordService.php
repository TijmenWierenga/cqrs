<?php
namespace TijmenWierenga\Project\Tests\Account\Testing\Service;

use TijmenWierenga\Project\Account\Domain\Model\User\InvalidPasswordException;
use TijmenWierenga\Project\Account\Domain\Model\User\UserPasswordService;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class PlainTextUserPasswordService implements UserPasswordService
{
    /**
     * Creates a new password
     *
     * @param string $password
     * @return string
     */
    public function hash(string $password): string
    {
        return $password;
    }

    /**
     * Verifies a given password against a hashed value
     *
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verify(string $password, string $hash): bool
    {
        if (! $password === $hash) {
            throw InvalidPasswordException::wrongPassword();
        }

        return true;
    }
}

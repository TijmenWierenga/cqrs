<?php
namespace TijmenWierenga\Project\Account\Infrastructure\Service\User;

use TijmenWierenga\Project\Account\Domain\Model\User\InvalidPasswordException;
use TijmenWierenga\Project\Account\Domain\Model\User\UserPasswordService;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class BcryptUserPasswordFactory implements UserPasswordService
{
    /**
     * Creates a new password
     *
     * @param string $password
     * @return string
     */
    public function hash(string $password): string
    {
        if (! strlen($password > UserPasswordService::PASSWORD_MIN_CHARS)) {
            throw InvalidPasswordException::tooShort($password);
        }

        return password_hash($password, PASSWORD_BCRYPT);
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
        if (! password_verify($password, $hash)) {
            throw InvalidPasswordException::wrongPassword();
        }

        return true;
    }
}

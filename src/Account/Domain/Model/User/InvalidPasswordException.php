<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use RuntimeException;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class InvalidPasswordException extends RuntimeException
{
    public static function tooShort(string $password): self
    {
        return new self(
            "The password needs to have a minimum of " . UserPasswordService::PASSWORD_MIN_CHARS ." characters." .
            "Provided password '{$password}' has only " . strlen($password) . "."
        );
    }

    public static function wrongPassword(): self
    {
        return new self("The given password is wrong");
    }
}

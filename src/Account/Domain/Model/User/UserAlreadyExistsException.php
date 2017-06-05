<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use RuntimeException;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserAlreadyExistsException extends RuntimeException
{
    public static function userExists(string $email): self
    {
        throw new self("{$email} is already in use by another user");
    }
}

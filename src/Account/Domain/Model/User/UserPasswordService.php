<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
interface UserPasswordService
{
    /**
     * Minimum amount of characters for a password
     */
    const PASSWORD_MIN_CHARS = 6;

    /**
     * Creates a new password
     *
     * @param string $password
     * @return string
     */
    public function hash(string $password): string;

    /**
     * Verifies a given password against a hashed value
     *
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verify(string $password, string $hash): bool;
}

<?php
namespace TijmenWierenga\Project\Account\Application\DataTransformer\User;

use TijmenWierenga\Project\Account\Domain\Model\User\User;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
interface UserDataTransformer
{
    /**
     * @param User $user
     */
    public function write(User $user): void;

    /**
     * Returns the transformed data
     *
     * @return mixed
     */
    public function read();
}

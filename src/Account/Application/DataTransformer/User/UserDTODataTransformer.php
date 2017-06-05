<?php
namespace TijmenWierenga\Project\Account\Application\DataTransformer\User;

use TijmenWierenga\Project\Account\Domain\Model\User\User;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserDTODataTransformer implements UserDataTransformer
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function write(User $user): void
    {
        $this->user = $user;
    }

    /**
     * Returns the transformed data
     *
     * @return User
     */
    public function read()
    {
        return $this->user;
    }
}

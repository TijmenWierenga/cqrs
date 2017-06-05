<?php
namespace TijmenWierenga\Project\Account\Application\DataTransformer\User;

use TijmenWierenga\Project\Account\Domain\Model\User\User;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class JsonUserDataTransformer implements UserDataTransformer
{
    /**
     * @var string
     */
    private $user;

    /**
     * @param User $user
     */
    public function write(User $user): void
    {
        $this->user = json_encode([
            'id' => (string) $user->getUserId(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'email' => (string) $user->getEmail()
        ]);
    }

    /**
     * Returns the transformed data
     *
     * @return mixed
     */
    public function read()
    {
        return $this->user;
    }
}

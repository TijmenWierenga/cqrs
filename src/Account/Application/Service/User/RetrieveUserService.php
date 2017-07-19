<?php

namespace TijmenWierenga\Project\Account\Application\Service\User;

use TijmenWierenga\Project\Account\Domain\Model\User\UserDataStore;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class RetrieveUserService
{
    /**
     * @var UserDataStore
     */
    private $userDataStore;

    /**
     * RetrieveUserService constructor.
     * @param UserDataStore $userDataStore
     */
    public function __construct(UserDataStore $userDataStore)
    {
        $this->userDataStore = $userDataStore;
    }

    /**
     * @param RetrieveUserRequest $request
     * @return RetrieveUserResponse
     */
    public function find(RetrieveUserRequest $request): RetrieveUserResponse
    {
        $user = $this->userDataStore->find(UserId::fromString($request->getUserId()));

        dump($user);

        return new RetrieveUserResponse($user);
    }
}

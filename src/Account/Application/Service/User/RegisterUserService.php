<?php
namespace TijmenWierenga\Project\Account\Application\Service\User;

use TijmenWierenga\Project\Account\Application\DataTransformer\User\UserDataTransformer;
use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Account\Domain\Model\User\UserAlreadyExistsException;
use TijmenWierenga\Project\Account\Domain\Model\User\UserDataStore;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Account\Domain\Model\User\UserRepository;
use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RegisterUserService 
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var UserDataStore
     */
    private $userDataStore;
    /**
     * @var UserDataTransformer
     */
    private $userDataTransformer;

    /**
     * RegisterUserService constructor.
     * @param UserRepository $userRepository
     * @param UserDataStore $userDataStore
     * @param UserDataTransformer $userDataTransformer
     */
    public function __construct(
        UserRepository $userRepository,
        UserDataStore $userDataStore,
        UserDataTransformer $userDataTransformer
    ) {
        $this->userRepository = $userRepository;
        $this->userDataStore = $userDataStore;
        $this->userDataTransformer = $userDataTransformer;
    }

    public function register(RegisterUserRequest $request): void
    {
        $email = new Email($request->getEmail());

        if ($this->userDataStore->emailAlreadyExists($email)) {
            UserAlreadyExistsException::userExists($email);
        }

        $user = User::new(
            UserId::new(),
            $email,
            $request->getFirstName(),
            $request->getLastName()
        );

        $this->userRepository->save($user);
        $this->userDataTransformer->write($user);
    }

    public function userDataTransformer(): UserDataTransformer
    {
        return $this->userDataTransformer;
    }
}

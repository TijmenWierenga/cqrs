<?php
namespace TijmenWierenga\Project\Account\Application\Service\User;

use TijmenWierenga\Project\Account\Application\DataTransformer\User\UserDataTransformer;
use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Account\Domain\Model\User\UserAlreadyExistsException;
use TijmenWierenga\Project\Account\Domain\Model\User\UserDataStore;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Account\Domain\Model\User\UserPasswordService;
use TijmenWierenga\Project\Account\Domain\Model\User\UserRepository;
use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
final class RegisterUserService
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
     * @var UserPasswordService
     */
    private $userPasswordService;

    /**
     * RegisterUserService constructor.
     * @param UserRepository $userRepository
     * @param UserDataStore $userDataStore
     * @param UserPasswordService $userPasswordService
     */
    public function __construct(
        UserRepository $userRepository,
        UserDataStore $userDataStore,
        UserPasswordService $userPasswordService
    ) {
        $this->userRepository = $userRepository;
        $this->userDataStore = $userDataStore;
        $this->userPasswordService = $userPasswordService;
    }

    /**
     * @param RegisterUserRequest $request
     * @return RegisterUserResponse
     */
    public function register(RegisterUserRequest $request): RegisterUserResponse
    {
        $email = new Email($request->getEmail());

        if ($this->userDataStore->emailAlreadyExists($email)) {
            UserAlreadyExistsException::userExists($email);
        }

        $user = User::new(
            UserId::new(),
            $email,
            $request->getFirstName(),
            $request->getLastName(),
            $this->userPasswordService->hash($request->getPassword())
        );

        $this->userRepository->save($user);

        return new RegisterUserResponse($user);
    }
}

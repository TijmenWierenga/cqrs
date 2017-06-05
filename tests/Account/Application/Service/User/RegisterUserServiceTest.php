<?php
namespace TijmenWierenga\Project\Tests\Account\Application\Service\User;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TijmenWierenga\Project\Account\Application\Service\User\RegisterUserRequest;
use TijmenWierenga\Project\Account\Application\Service\User\RegisterUserService;
use TijmenWierenga\Project\Account\Application\DataTransformer\User\UserDTODataTransformer;
use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Account\Domain\Model\User\UserAlreadyExistsException;
use TijmenWierenga\Project\Account\Domain\Model\User\UserDataStore;
use TijmenWierenga\Project\Tests\Account\Testing\Repository\InMemoryUserRepository;
use TijmenWierenga\Project\Tests\Account\Testing\Service\PlainTextUserPasswordService;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RegisterUserServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_does_not_register_a_user_when_email_address_is_in_use()
    {
        $this->expectException(UserAlreadyExistsException::class);
        $userRepository = new InMemoryUserRepository();
        $userDataTransformer = new UserDTODataTransformer();
        $userPasswordService = new PlainTextUserPasswordService();
        /** @var UserDataStore|PHPUnit_Framework_MockObject_MockObject $dataStore */
        $dataStore = $this->getMockBuilder(UserDataStore::class)->getMock();

        $dataStore->expects($this->once())
            ->method('emailAlreadyExists')
            ->with('tijmen@devmob.com')
            ->willReturn(true);

    	$service = new RegisterUserService($userRepository, $dataStore, $userDataTransformer, $userPasswordService);
    	$service->register(new RegisterUserRequest(
    	    'Tijmen',
            'Wierenga',
            'tijmen@devmob.com',
            'a-password'
            )
        );
    }

    /**
     * @test
     */
    public function it_registers_a_user()
    {
        $userRepository = new InMemoryUserRepository();
        $userDataTransformer = new UserDTODataTransformer();
        $userPasswordService = new PlainTextUserPasswordService();
        /** @var UserDataStore|PHPUnit_Framework_MockObject_MockObject $dataStore */
        $dataStore = $this->getMockBuilder(UserDataStore::class)->getMock();

        $dataStore->expects($this->once())
            ->method('emailAlreadyExists')
            ->with('tijmen@devmob.com')
            ->willReturn(false);

        $service = new RegisterUserService($userRepository, $dataStore, $userDataTransformer, $userPasswordService);
        $service->register(new RegisterUserRequest(
                'Tijmen',
                'Wierenga',
                'tijmen@devmob.com',
                'a-password'
            )
        );

        /** @var User $user */
        $user = $service->userDataTransformer()->read();

        $this->assertEquals($user, $userRepository->find($user->getUserId()));
    }
}

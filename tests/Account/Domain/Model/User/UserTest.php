<?php
namespace TijmenWierenga\Project\Tests\Common\Domain\Model\User;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;
use TijmenWierenga\Project\Common\Domain\Event\EventStream;
use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Account\Domain\Model\User\UserWasCreated;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserTest extends TestCase
{
    /**
     * @test
     */
    public function a_user_can_be_created()
    {
        $userId = UserId::new();
    	$user = User::new($userId, 't.wierenga@live.nl', 'Tijmen', 'Wierenga', 'a-password');

    	$this->assertInstanceOf(User::class, $user);
    	$this->assertEquals($userId, $user->getUserId());
    	$this->assertEquals('t.wierenga@live.nl', (string) $user->getEmail());
    	$this->assertEquals('Tijmen', $user->getFirstName());
    	$this->assertEquals('Wierenga', $user->getLastName());
    }

    /**
     * @test
     */
    public function a_user_can_be_reconstituted()
    {
        $userId = UserId::new();
        $events = [
            new UserWasCreated($userId, 'john.doe@example.com', 'John', 'Doe', 'a-password')
        ];

    	$history = new EventStream((string) $userId, $events);
    	/** @var User $user */
        $user = User::reconstitute($history);

        $this->assertEquals('John', $user->getFirstName());
        $this->assertEquals('Doe', $user->getLastName());
        $this->assertEquals('john.doe@example.com', (string) $user->getEmail());
        $this->assertEquals($userId, $user->getUserId());
    }
}

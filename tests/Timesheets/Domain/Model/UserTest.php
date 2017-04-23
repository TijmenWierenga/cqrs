<?php
namespace TijmenWierenga\Project\Tests\Timesheets\Domain\Model\User;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Timesheets\Domain\Model\User\User;
use TijmenWierenga\Project\Timesheets\Domain\Model\User\UserId;

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
    	$user = User::new($userId, 'Tijmen', 'Wierenga');

    	$this->assertInstanceOf(User::class, $user);
    	$this->assertEquals($userId, $user->getUserId());
    	$this->assertEquals('Tijmen', $user->getFirstName());
    	$this->assertEquals('Wierenga', $user->getLastName());
    }
}

<?php
namespace TijmenWierenga\Project\Tests\Account\Application\DataTransformer\User;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Account\Application\DataTransformer\User\JsonUserDataTransformer;
use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class JsonUserDataTransformerTest extends TestCase
{
    /**
     * @test
     */
    public function it_writes_a_user_to_json()
    {
    	$user = User::new(UserId::new(), 'tijmen@devmob.com', 'Tijmen', 'Wierenga');
    	$transformer = new JsonUserDataTransformer();
    	$transformer->write($user);
    	$json = $transformer->read();

    	$this->assertJson($json);

    	$decodedUser = json_decode($json);
    	$this->assertEquals('tijmen@devmob.com', $decodedUser->email);
    }
}

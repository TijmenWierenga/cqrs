<?php
namespace TijmenWierenga\Project\Tests\Account\Infrastructure\Service\User;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Account\Domain\Model\User\InvalidPasswordException;
use TijmenWierenga\Project\Account\Infrastructure\Service\User\BcryptUserPasswordService;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class BcryptUserPasswordServiceTest extends TestCase
{
    /**
     * @test
     */
    public function it_does_not_accept_a_password_less_than_the_minimum_amount_of_chars()
    {
        $this->expectException(InvalidPasswordException::class);

    	$service = new BcryptUserPasswordService();
    	$service->hash('123');
    }
}

<?php
namespace TijmenWierenga\Project\Tests\Timesheets\Infrastructure;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TijmenWierenga\Project\Timesheets\Infrastructure\App;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class AppTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_the_application()
    {
    	$app = new App();
    	$app->run();

    	$this->assertInstanceOf(ContainerInterface::class, App::getContainer());

    	return $app;
    }
}

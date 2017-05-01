<?php
namespace TijmenWierenga\Project\Tests\Timesheets\Infrastructure\Bootstrap;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TijmenWierenga\Project\Timesheets\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Timesheets\Infrastructure\Bootstrap\EnvironmentException;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class AppTest extends TestCase
{
    /**
     * @test
     */
    public function it_runs_the_application(): App
    {
    	$app = new App();
    	$app->run('test');

    	$this->assertInstanceOf(ContainerInterface::class, App::container());

    	return $app;
    }

    /**
     * @test
     * @depends it_runs_the_application
     * @param App $app
     */
    public function an_app_has_an_environment(App $app)
    {
    	$this->assertEquals('test', $app::environment());
    }

    /**
     * @test
     */
    public function it_cannot_start_the_app_with_an_invalid_environment()
    {
        $this->expectException(EnvironmentException::class);

    	$app = new App();
    	$app->run('rainbow');
    }
}

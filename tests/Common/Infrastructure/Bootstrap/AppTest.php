<?php
namespace TijmenWierenga\Project\Tests\Common\Infrastructure\Bootstrap;

use PHPUnit\Framework\TestCase;
use ReflectionProperty;
use Symfony\Component\DependencyInjection\ContainerInterface;
use TijmenWierenga\Project\Account\Infrastructure\Service\User\BcryptUserPasswordService;
use TijmenWierenga\Project\Common\Domain\Projection\Projector;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\CompilerPass\ProjectorCompilerPass;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\EnvironmentException;

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
     * @return App
     */
    public function an_app_has_an_environment(App $app): App
    {
    	$this->assertEquals('test', $app::environment());

    	return $app;
    }

    /**
     * @test
     * @depends an_app_has_an_environment
     * @param App $app
     */
    public function it_registers_the_projector_with_listeners(App $app)
    {
    	$projector = $app::container()->get(ProjectorCompilerPass::SERVICE_NAME);

    	$this->assertInstanceOf(Projector::class, $projector);

    	$property = new ReflectionProperty($projector, 'projections');
    	$property->setAccessible(true);
    	$projections = $property->getValue($projector);
    	$property->setAccessible(false);

    	$this->assertNotEmpty($projections);
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

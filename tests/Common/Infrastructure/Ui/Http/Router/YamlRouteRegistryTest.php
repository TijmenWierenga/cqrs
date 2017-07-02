<?php
namespace TijmenWierenga\Project\Tests\Common\Infrastructure\Ui\Http\Router;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Common\Domain\Model\File\File;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\RouteDefinition;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\YamlRouteRegistry;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class YamlRouteRegistryTest extends TestCase
{
    /**
     * @test
     */
    public function it_loads_all_routes_from_the_config()
    {
    	$registry = new YamlRouteRegistry([new File(realpath(__DIR__ . '/routes.yml'))]);

    	$this->assertContainsOnlyInstancesOf(RouteDefinition::class, $registry->getRouteDefinitions());
    }
}

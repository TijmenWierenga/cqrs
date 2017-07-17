<?php
namespace TijmenWierenga\Project\Tests\Common\Infrastructure\Ui\Http\Router;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Common\Domain\Model\File\File;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\MiddlewareHandler;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\RouteDefinition;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\RouteHandler;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\RouteMiddleware;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\RouteRegistry;
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
        $this->assertCount(2, $registry->getRouteDefinitions());

        return $registry;
    }

    /**
     * @test
     * @depends it_loads_all_routes_from_the_config
     * @param RouteRegistry $registry
     * @return RouteRegistry
     */
    public function route_definition_has_a_handler(RouteRegistry $registry)
    {
        $route = $registry->getRouteDefinitions()[0];

        $this->assertInstanceOf(RouteHandler::class, $route->getHandler());
        $this->assertEquals('account.service.user.register', $route->getHandler()->getServiceId());
        $this->assertEquals('register', $route->getHandler()->getMethod());

        return $registry;
    }

    /**
     * @test
     * @depends route_definition_has_a_handler
     * @param RouteRegistry $registry
     */
    public function route_definition_has_correct_middleware(RouteRegistry $registry)
    {
        $route = $registry->getRouteDefinitions()[0];
        $middleware = $route->getMiddleware();

        $this->assertInstanceOf(RouteMiddleware::class, $middleware);
        $this->assertContainsOnlyInstancesOf(MiddlewareHandler::class, $middleware->getBeforeMiddleware());
        $this->assertCount(2, $middleware->getBeforeMiddleware());
        $this->assertCount(3, $middleware->getBeforeMiddleware()[0]->getArguments());
        $this->assertEmpty($middleware->getAfterMiddleware()[0]->getArguments());
    }
}

<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class SimpleRouter implements Router
{
    /**
     * @var RouteRegistry
     */
    private $routeRegistry;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * SimpleRouter constructor.
     * @param RouteRegistry $routeRegistry
     */
    public function __construct(RouteRegistry $routeRegistry)
    {
        $this->routeRegistry = $routeRegistry;
        $this->registerRoutes();
    }

    /**
     * @param Route $route
     */
    public function find(Route $route)
    {
        return $this->dispatcher->dispatch($route->getHttpMethod(), $route->getUri());
    }

    private function registerRoutes()
    {
        $this->dispatcher = simpleDispatcher(function (RouteCollector $r) {
            foreach ($this->routeRegistry->getRouteDefinitions() as $routeDefinition) {
                $r->addRoute(
                    $routeDefinition->getMethod(),
                    $routeDefinition->getUri(),
                    $routeDefinition
                );
            }
        });
    }
}

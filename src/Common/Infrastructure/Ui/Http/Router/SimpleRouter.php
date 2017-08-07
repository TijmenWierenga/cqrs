<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpException;

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
     * @return Match
     */
    public function find(Route $route): Match
    {
        $routeInfo = $this->dispatcher->dispatch($route->getHttpMethod(), $route->getUri());
        list($status, $routeDefinition, $routeVars) = $routeInfo;

        if ($status === Router::NOT_FOUND) {
            throw HttpException::notFound();
        }

        if ($status === Router::METHOD_NOT_ALLOWED) {
            throw HttpException::methodNotAllowed($routeDefinition);
        }

        return new Match($routeDefinition, new RouteVars($routeVars));
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

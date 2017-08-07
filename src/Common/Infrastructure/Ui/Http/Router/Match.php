<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class Match
{
    /**
     * @var RouteDefinition
     */
    private $routeDefinition;
    /**
     * @var RouteVars
     */
    private $routeVars;

    /**
     * Match constructor.
     * @param RouteDefinition $routeDefinition
     * @param RouteVars $routeVars
     * @internal param RouteVars $vars
     */
    public function __construct(RouteDefinition $routeDefinition, RouteVars $routeVars)
    {
        $this->routeDefinition = $routeDefinition;
        $this->routeVars = $routeVars;
    }

    /**
     * @return RouteDefinition
     */
    public function getRouteDefinition(): RouteDefinition
    {
        return $this->routeDefinition;
    }

    /**
     * @return RouteVars
     */
    public function getRouteVars(): RouteVars
    {
        return $this->routeVars;
    }
}

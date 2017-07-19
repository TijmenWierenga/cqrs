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
     * @var array
     */
    private $vars;

    /**
     * Match constructor.
     * @param RouteDefinition $routeDefinition
     * @param array $vars
     */
    public function __construct(RouteDefinition $routeDefinition, array $vars)
    {
        $this->routeDefinition = $routeDefinition;
        $this->vars = $vars;
    }

    /**
     * @return RouteDefinition
     */
    public function getRouteDefinition(): RouteDefinition
    {
        return $this->routeDefinition;
    }

    /**
     * @return array
     */
    public function getVars(): array
    {
        return $this->vars;
    }
}

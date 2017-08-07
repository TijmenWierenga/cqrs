<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\RouteVars;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RequestAttributes
{
    /**
     * @var RouteVars
     */
    private $routeVars;

    /**
     * RequestAttributes constructor.
     * @param RouteVars $routeVars
     */
    public function __construct(RouteVars $routeVars)
    {
        $this->routeVars = $routeVars;
    }

    /**
     * @return RouteVars
     */
    public function getRouteVars(): RouteVars
    {
        return $this->routeVars;
    }
}

<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

/**
 * @package TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router
 */
interface Router
{
    const NOT_FOUND = 0;
    const FOUND = 1;
    const METHOD_NOT_ALLOWED = 2;
    const STATUSES = [self::NOT_FOUND, self::FOUND, self::METHOD_NOT_ALLOWED];

    /**
     * @param Route $route
     * @return RouteDefinition
     */
    public function find(Route $route): RouteDefinition;
}

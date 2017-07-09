<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

use Assert\Assertion;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class Result
{
    const NOT_FOUND = 0;
    const FOUND = 1;
    const METHOD_NOT_ALLOWED = 2;
    const STATUSES = [self::NOT_FOUND, self::FOUND, self::METHOD_NOT_ALLOWED];

    /**
     * @var int
     */
    private $status;
    /**
     * @var RouteDefinition
     */
    private $routeDefinition;
    private $vars;

    /**
     * Result constructor.
     * @param int $status
     * @param RouteDefinition $routeDefinition
     * @param $vars
     */
    public function __construct(int $status, RouteDefinition $routeDefinition, $vars)
    {
        Assertion::inArray($status, self::STATUSES);

        $this->status = $status;
        $this->routeDefinition = $routeDefinition;
        $this->vars = $vars;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return RouteDefinition
     */
    public function getRouteDefinition(): RouteDefinition
    {
        return $this->routeDefinition;
    }

    /**
     * @return mixed
     */
    public function getVars()
    {
        return $this->vars;
    }
}

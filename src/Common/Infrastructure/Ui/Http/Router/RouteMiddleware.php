<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class RouteMiddleware
{
    /**
     * @var iterable|MiddlewareHandler[]
     */
    private $before;
    /**
     * @var iterable|MiddlewareHandler[]
     */
    private $after;

    /**
     * RouteMiddleware constructor.
     * @param iterable $before
     * @param iterable $after
     */
    public function __construct(iterable $before, iterable $after)
    {
        $this->before = $before;
        $this->after = $after;
    }

    /**
     * @return iterable|MiddlewareHandler[]
     */
    public function getBeforeMiddleware()
    {
        return $this->before;
    }

    /**
     * @return iterable|MiddlewareHandler[]
     */
    public function getAfterMiddleware()
    {
        return $this->after;
    }
}

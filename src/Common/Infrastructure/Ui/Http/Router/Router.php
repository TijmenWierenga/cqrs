<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;


interface Router
{
    /**
     * @param Route $route
     */
    public function find(Route $route);
}
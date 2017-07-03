<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;


/**
 * @package TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router
 */
interface Router
{
    /**
     * @param Route $route
     * @return Result
     */
    public function find(Route $route): Result;
}

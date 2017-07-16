<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

interface RouteRegistry
{
    /**
     * @return array|RouteDefinition[]
     */
    public function getRouteDefinitions(): array;
}

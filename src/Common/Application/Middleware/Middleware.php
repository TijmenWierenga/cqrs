<?php
namespace TijmenWierenga\Project\Common\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @package TijmenWierenga\Project\Common\Application\Middleware\Middleware
 * @author  Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
interface Middleware
{
    /**
     * @param ServerRequestInterface $request
     * @param array ...$params
     */
    public function handle(ServerRequestInterface $request, ...$params): void;
}

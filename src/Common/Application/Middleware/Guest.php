<?php

namespace TijmenWierenga\Project\Common\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class Guest implements Middleware
{

    /**
     * @param ServerRequestInterface $request
     * @param array ...$params
     */
    public function handle(ServerRequestInterface $request, ...$params): void
    {
        // TODO: Implement handle() method.
    }
}

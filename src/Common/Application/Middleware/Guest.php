<?php

namespace TijmenWierenga\Project\Common\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamData;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class Guest implements Middleware
{

    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param array ...$params
     */
    public function handle(ServerRequestInterface $request, StreamData $streamData, ...$params): void
    {
        // TODO: Implement handle() method.
    }
}

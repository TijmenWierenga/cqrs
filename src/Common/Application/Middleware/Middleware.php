<?php
namespace TijmenWierenga\Project\Common\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamData;

/**
 * @package TijmenWierenga\Project\Common\Application\Middleware\Middleware
 * @author  Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
interface Middleware
{
    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param array ...$params
     */
    public function handle(ServerRequestInterface $request, StreamData $streamData, ...$params): void;
}

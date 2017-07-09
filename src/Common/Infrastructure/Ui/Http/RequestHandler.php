<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author  Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
interface RequestHandler
{
    /**
     * Handles a server request and returns an appropriate response
     *
     * @param ServerRequestInterface $request
     * @param $streamData
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request, StreamData $streamData): ResponseInterface;
}

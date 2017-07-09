<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Tijmen Wierenga <tijmen@devmob.com>
 */
interface HttpRequest
{
    /**
     * Generates a Service Request from a HttpRequest (ServerRequestInterface)
     *
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @return HttpRequest
     */
    public static function createFromHttpRequest(ServerRequestInterface $request, StreamData $streamData);
}
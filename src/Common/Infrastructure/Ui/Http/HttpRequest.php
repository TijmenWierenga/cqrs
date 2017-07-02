<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;


use Psr\Http\Message\ServerRequestInterface;

interface HttpRequest
{
    /**
     * Generates a Service Request from a HttpRequest (ServerRequestInterface)
     *
     * @param ServerRequestInterface $request
     * @return HttpRequest
     */
    public static function createFromHttpRequest(ServerRequestInterface $request): self;
}
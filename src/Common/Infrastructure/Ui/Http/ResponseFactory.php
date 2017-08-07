<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class ResponseFactory
{
    const DEFAULT_CONTENT_TYPE = 'application/json';

    /**
     * @param ServerRequestInterface $request
     * @param HttpResponse $response
     * @return ResponseInterface
     */
    public static function generate(ServerRequestInterface $request, HttpResponse $response): ResponseInterface
    {
        switch ($request->getHeader('Content-Type')) {
            case 'application/json':
            default:
                return self::parseJsonResponse($response);
        }
    }

    /**
     * @param HttpResponse $response
     * @return Response
     */
    private static function parseJsonResponse(HttpResponse $response)
    {
        return new Response(
            $response->getStatusCode(),
            array_merge(['Content-Type' => self::DEFAULT_CONTENT_TYPE], $response->getHeaders()),
            json_encode(['data' => $response->getData()])
        );
    }
}

<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use FastRoute\Dispatcher;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\Route;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\Router;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\UriHelper;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class ContainerAwareRequestHandler implements RequestHandler
{
    /**
     * @var ContainerInterface
     */
    private $container;
    /**
     * @var Router
     */
    private $router;

    /**
     * ContainerAwareRequestHandler constructor.
     * @param ContainerInterface $container
     * @param Router $router
     */
    public function __construct(ContainerInterface $container, Router $router)
    {
        $this->container = $container;
        $this->router = $router;
    }

    /**
     * Handles a server request and returns an appropriate response
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $routeInfo = $this->router->find(
            new Route(
                $request->getMethod(),
                UriHelper::stripQuery($request->getUri()->getPath())
            )
        );

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return new Response(404, [
                    'content-type' => 'application/json'
                ]);
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                return new Response(405, [
                    'content-type' => 'application/json'
                ]);
                break;
            default:
            case Dispatcher::FOUND:
                // TODO: Call global middleware (before)
                // TODO: Call route-specific middleware (before)
                // TODO: Get handler service
                // TODO: Use reflection to get the Request class
                // TODO: Construct Request class
                // TODO: Call Service Handler
                // TODO: Transform Response based on accept header
                // TODO: Call route-specific middleware (after)
                // TODO: Call global middleware (after)

                return new Response(200, [
                    'content-type' => 'application/json'
                ], json_encode("We found your endpoint"));
                break;
        }
    }
}

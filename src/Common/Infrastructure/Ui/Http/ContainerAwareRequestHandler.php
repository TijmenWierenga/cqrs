<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use ReflectionParameter;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\Result;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\Route;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\RouteDefinition;
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

        switch ($routeInfo->getStatus()) {
            case Result::NOT_FOUND:
                return $this->notFound();
                break;
            case Result::METHOD_NOT_ALLOWED:
                return $this->methodNotAllowed();
                break;
            default:
            case Result::FOUND:
                return $this->found($request, $routeInfo->getRouteDefinition());
                break;
        }
    }

    /**
     * @return ResponseInterface
     */
    private function notFound(): ResponseInterface
    {
        return new Response(404, [
            'content-type' => 'application/json'
        ]);
    }

    /**
     * @return ResponseInterface
     */
    private function methodNotAllowed(): ResponseInterface
    {
        return new Response(405, [
            'content-type' => 'application/json'
        ]);
    }

    /**
     * @param ServerRequestInterface $request
     * @param RouteDefinition $routeDefinition
     * @return ResponseInterface
     */
    private function found(ServerRequestInterface $request, RouteDefinition $routeDefinition): ResponseInterface
    {
        $routeHandler = $routeDefinition->getHandler();
        // TODO: Call global middleware (before)
        // TODO: Call route-specific middleware (before)
        $service = $this->container->get($routeHandler->getServiceId());
        $method = $routeHandler->getMethod();
        $serviceRequest = $this->generateServiceRequest($request, $service, $method);
        $response = $service->$method($serviceRequest);
        // TODO: Transform Response based on accept header
        // TODO: Call route-specific middleware (after)
        // TODO: Call global middleware (after)

        return new Response(200, [
            'content-type' => 'application/json'
        ], json_encode("We found your endpoint"));
    }

    /**
     * @param ServerRequestInterface $request
     * @param $service
     * @param string $method
     * @return object
     */
    private function generateServiceRequest(ServerRequestInterface $request, $service, string $method)
    {
        $requestInfo = new ReflectionParameter([$service, $method], 0);
        $serviceRequest = (string) $requestInfo->getType();

        return call_user_func([$serviceRequest, 'createFromHttpRequest'], $request);
    }
}

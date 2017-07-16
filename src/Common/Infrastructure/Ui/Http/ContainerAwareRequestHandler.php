<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Exception;
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
     * @param StreamData $streamData
     * @return ResponseInterface
     * @internal param StreamData $data
     */
    public function handle(ServerRequestInterface $request, StreamData $streamData): ResponseInterface
    {
        try {
            $routeDefinition = $this->getRouteDefinition($request->getMethod(), $request->getUri()->getPath());

            return $this->handleRequest($request, $streamData, $routeDefinition);
        } catch (HttpException $e) {
            // TODO: Transform response based on content type
            return new Response(
                $e->getStatusCode(),
                ['Content-Type' => 'application/json'],
                json_encode($e->getData())
            );
        } catch (Exception $e) {
            return new Response(
                500,
                ['Content-Type' => 'application/json'],
                json_encode($e->getMessage())
            );
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param RouteDefinition $routeDefinition
     * @return ResponseInterface
     */
    private function handleRequest(
        ServerRequestInterface $request,
        StreamData $streamData,
        RouteDefinition $routeDefinition
    ): ResponseInterface {
        // TODO: Wrap in try/catch block
        $routeHandler = $routeDefinition->getHandler();
        // TODO: Call global middleware (before)
        // TODO: Call route-specific middleware (before)
        $service = $this->container->get($routeHandler->getServiceId());
        $method = $routeHandler->getMethod();
        $serviceRequest = $this->generateServiceRequest($request, $streamData, $service, $method);
        // TODO: Note to self: create controller and return response that can be transformed based on accept header
        $response = $service->$method($serviceRequest);
        // TODO: Transform Response based on accept header
        // TODO: Call route-specific middleware (after)
        // TODO: Call global middleware (after)
        // TODO: Catch \Error and return 500 error response

        return new Response(200, [
            'Content-Type' => 'application/json'
        ], json_encode($response));
    }

    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param $service
     * @param string $method
     * @return object
     */
    private function generateServiceRequest(
        ServerRequestInterface $request,
        StreamData $streamData,
        $service,
        string $method
    ) {
        $requestInfo = new ReflectionParameter([$service, $method], 0);
        $serviceRequest = (string) $requestInfo->getType();

        return call_user_func_array([$serviceRequest, 'createFromHttpRequest'], [$request, $streamData]);
    }

    /**
     * @param string $method
     * @param string $path
     * @return RouteDefinition
     */
    private function getRouteDefinition(string $method, string $path): RouteDefinition
    {
        return $this->router->find(
            new Route($method, UriHelper::stripQuery($path))
        );
    }
}

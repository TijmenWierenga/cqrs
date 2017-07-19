<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Error;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use ReflectionParameter;
use TijmenWierenga\Project\Common\Application\Middleware\Middleware;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\Match;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\MiddlewareHandler;
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
     * @var array
     */
    private $globalMiddleware;

    /**
     * ContainerAwareRequestHandler constructor.
     * @param ContainerInterface $container
     * @param Router $router
     */
    public function __construct(ContainerInterface $container, Router $router)
    {
        $this->container = $container;
        $this->router = $router;
        $this->registerGlobalMiddleware();
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
            $route = $this->matchRoute($request->getMethod(), $request->getUri()->getPath());

            return $this->handleRequest($request, $streamData, $route);
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
        } catch (Error $e) {
            return new Response(
                400,
                ['Content-Type' => 'application/json'],
                json_encode($e->getMessage())
            );
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param Match $match
     * @return ResponseInterface
     */
    private function handleRequest(
        ServerRequestInterface $request,
        StreamData $streamData,
        Match $match
    ): ResponseInterface {
        $routeDefinition = $match->getRouteDefinition();
        $routeHandler = $routeDefinition->getHandler();

        $this->callMiddleware(
            $request,
            $streamData,
            $routeDefinition->getMiddleware()->getBeforeMiddleware(),
            $this->globalMiddleware['before']
        );

        $service = $this->container->get($routeHandler->getServiceId());
        $method = $routeHandler->getMethod();
        $serviceRequest = $this->generateServiceRequest($request, $streamData, $match->getVars(), $service, $method);
        /** @var HttpResponse $serviceResponse */
        $serviceResponse = $service->$method($serviceRequest);

        $this->callMiddleware(
            $request,
            $streamData,
            $this->globalMiddleware['after'],
            $routeDefinition->getMiddleware()->getAfterMiddleware()
        );

        return ResponseFactory::generate($request, $serviceResponse);
    }

    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param array $routeVars
     * @param $service
     * @param string $method
     * @return object
     */
    private function generateServiceRequest(
        ServerRequestInterface $request,
        StreamData $streamData,
        array $routeVars,
        $service,
        string $method
    ) {
        $requestInfo = new ReflectionParameter([$service, $method], 0);
        $serviceRequest = (string) $requestInfo->getType();

        return call_user_func_array([$serviceRequest, 'createFromHttpRequest'], [$request, $streamData, $routeVars]);
    }

    /**
     * @param string $method
     * @param string $path
     * @return Match
     */
    private function matchRoute(string $method, string $path): Match
    {
        return $this->router->find(
            new Route($method, UriHelper::stripQuery($path))
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param array ...$middlewareCollections
     */
    private function callMiddleware(
        ServerRequestInterface $request,
        StreamData $streamData,
        ...$middlewareCollections
    ): void {
        foreach ($middlewareCollections as $middlewareCollection) {
            $this->handleMiddleware($request, $streamData, $middlewareCollection);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param iterable|MiddlewareHandler[] $middlewareCollection
     */
    private function handleMiddleware(
        ServerRequestInterface $request,
        StreamData $streamData,
        iterable $middlewareCollection
    ): void {
        foreach ($middlewareCollection as $handler) {
            /** @var Middleware $service */
            $service = $this->container->get($handler->getServiceId());
            $service->handle($request, $streamData, ...$handler->getArguments());
        }
    }

    private function registerGlobalMiddleware(): void
    {
        $this->globalMiddleware['before'] = $this->registerGlobalBeforeMiddleware();
        $this->globalMiddleware['after'] = $this->registerGlobalAfterMiddleware();
    }

    /**
     * Register all global before middleware here.
     * For every middleware added, it will call the handle method with the parameters provided.
     *
     * @return array|MiddlewareHandler[]
     */
    private function registerGlobalBeforeMiddleware(): array
    {
        $middleware = [];

        if (App::environment() === App::ENVIRONMENT_DEVELOPMENT) {
            $middleware = array_merge($middleware, [
                new MiddlewareHandler('common.middleware.log_request', [App::environment()])
            ]);
        }

        return $middleware;
    }

    /**
     * Register all global before middleware here.
     * For every middleware added, it will call the handle method with the parameters provided.
     *
     * @return array
     */
    private function registerGlobalAfterMiddleware(): array
    {
        return [];
    }
}

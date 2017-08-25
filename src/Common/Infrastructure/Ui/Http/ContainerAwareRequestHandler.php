<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Error;
use Exception;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Response;
use ReflectionException;
use ReflectionParameter;
use TijmenWierenga\Project\Common\Application\Middleware\Middleware;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\Match;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\MiddlewareHandler;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\Route;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\Router;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\UriHelper;
use TijmenWierenga\Server\RequestHandler;

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
     * @return ResponseInterface
     * @internal param StreamData $data
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $route = $this->matchRoute($request->getMethod(), $request->getUri()->getPath());
            $request = $request->withAttribute('route', $route);

            return $this->handleRequest($request);
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
     * @return ResponseInterface
     */
    private function handleRequest(
        ServerRequestInterface $request
    ): ResponseInterface {
        /** @var Match $route */
        $route = $request->getAttribute('route');
        $routeDefinition = $route->getRouteDefinition();
        $routeHandler = $routeDefinition->getHandler();

        $this->callMiddleware(
            $request,
            $routeDefinition->getMiddleware()->getBeforeMiddleware(),
            $this->globalMiddleware['before']
        );

        $service = $this->container->get($routeHandler->getServiceId());
        $method = $routeHandler->getMethod();
        $serviceRequest = $this->generateServiceRequest($request, $service, $method);
        /** @var HttpResponse $serviceResponse */
        $serviceResponse = $service->$method($serviceRequest);

        $this->callMiddleware(
            $request,
            $this->globalMiddleware['after'],
            $routeDefinition->getMiddleware()->getAfterMiddleware()
        );

        return ResponseFactory::generate($request, $serviceResponse);
    }

    /**
     * @param ServerRequestInterface $request
     * @param $service
     * @param string $method
     * @return object|null
     */
    private function generateServiceRequest(
        ServerRequestInterface $request,
        $service,
        string $method
    ) {
        try {
            $requestInfo = new ReflectionParameter([$service, $method], 0);
        } catch (ReflectionException $e) {
            return null; // If method does not have an argument, we return null.
        }

        $serviceRequest = (string) $requestInfo->getType();

        return call_user_func_array([$serviceRequest, 'createFromHttpRequest'], [$request]);
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
     * @param array ...$middlewareCollections
     */
    private function callMiddleware(
        ServerRequestInterface $request,
        ...$middlewareCollections
    ): void {
        foreach ($middlewareCollections as $middlewareCollection) {
            $this->handleMiddleware($request, $middlewareCollection);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @param iterable|MiddlewareHandler[] $middlewareCollection
     */
    private function handleMiddleware(
        ServerRequestInterface $request,
        iterable $middlewareCollection
    ): void {
        foreach ($middlewareCollection as $handler) {
            /** @var Middleware $service */
            $service = $this->container->get($handler->getServiceId());
            $service->handle($request, ...$handler->getArguments());
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

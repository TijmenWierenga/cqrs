<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

use Symfony\Component\Yaml\Yaml;
use TijmenWierenga\Project\Common\Application\Middleware\Middleware;
use TijmenWierenga\Project\Common\Domain\Model\File\File;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class YamlRouteRegistry implements RouteRegistry
{
    /**
     * @var array
     */
    private $routeDefinitions = [];

    /**
     * YamlRouteRegistry constructor.
     * @param iterable $files
     */
    public function __construct(iterable $files)
    {
        $this->parse($files);
    }

    /**
     * @param iterable File[]
     */
    private function parse(iterable $files): void
    {
        /** @var File $file */
        foreach ($files as $file) {
            $groups = Yaml::parse(file_get_contents($file->getPath()));
            $groupBaseUris = array_keys($groups);

            $x = 0;
            foreach ($groups as $group) {
                $routeNames = array_keys($group['endpoints']);

                $y = 0;
                foreach ($group['endpoints'] as $endpoint) {
                    $definition = new RouteDefinition(
                        $groupBaseUris[$x] . '.' . $routeNames[$y],
                        $endpoint['method'],
                        $groupBaseUris[$x],
                        $groupBaseUris[$x] . $endpoint['uri'],
                        new RouteHandler($endpoint['handler']['id'], $endpoint['handler']['method']),
                        $this->parseMiddleware($endpoint['middleware'])
                    );

                    $this->routeDefinitions[] = $definition;
                    $y++;
                }

                $x++;
            }
        }
    }

    /**
     * @return array|RouteDefinition[]
     */
    public function getRouteDefinitions(): array
    {
        return $this->routeDefinitions;
    }

    /**
     * @param array|null $middleware
     * @return RouteMiddleware
     */
    private function parseMiddleware(?array $middleware): RouteMiddleware
    {
        $before = [];
        $after = [];

        if ($middleware) {
            foreach ($middleware as $when => $handlers) {
                foreach ($handlers as $handler) {
                    $id = array_keys($handler)[0];
                    $arguments = array_values($handler)[0];

                    if (! $arguments) {
                        $arguments = [];
                    }

                    ${$when}[] = new MiddlewareHandler($id, $arguments);
                }
            }
        }

        return new RouteMiddleware($before, $after);
    }
}

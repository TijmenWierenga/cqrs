<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RouteDefinition
{
    /**
     * @var string
     */
    private $group;
    /**
     * @var string
     */
    private $uri;
    /**
     * @var RouteHandler
     */
    private $handler;
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $method;

    /**
     * RouteDefinition constructor.
     * @param string $name
     * @param string $method
     * @param string $group
     * @param string $uri
     * @param RouteHandler $handler
     */
    public function __construct(string $name, string $method, string $group, string $uri, RouteHandler $handler)
    {
        $this->group = $group;
        $this->uri = UriHelper::format($uri);
        $this->handler = $handler;
        $this->name = $name;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getGroup(): string
    {
        return $this->group;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return RouteHandler
     */
    public function getHandler(): RouteHandler
    {
        return $this->handler;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}

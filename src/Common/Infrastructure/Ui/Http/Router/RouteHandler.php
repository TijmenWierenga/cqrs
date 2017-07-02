<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;


class RouteHandler
{
    /**
     * @var string
     */
    private $serviceId;
    /**
     * @var string
     */
    private $method;

    /**
     * RouteHandler constructor.
     * @param string $serviceId
     * @param string $method
     */
    public function __construct(string $serviceId, string $method)
    {
        $this->serviceId = $serviceId;
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
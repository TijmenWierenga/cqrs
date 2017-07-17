<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class MiddlewareHandler
{
    /**
     * @var string
     */
    private $serviceId;
    /**
     * @var array
     */
    private $arguments;

    /**
     * MiddlewareHandler constructor.
     * @param string $serviceId
     * @param array $arguments
     */
    public function __construct(string $serviceId, array $arguments)
    {
        $this->serviceId = $serviceId;
        $this->arguments = $arguments;
    }

    /**
     * @return string
     */
    public function getServiceId(): string
    {
        return $this->serviceId;
    }

    /**
     * @return array
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}

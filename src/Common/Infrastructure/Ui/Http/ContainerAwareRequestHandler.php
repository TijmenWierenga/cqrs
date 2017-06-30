<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
     * ContainerAwareRequestHandler constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Handles a server request and returns an appropriate response
     *
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // TODO: Implement handle() method.
    }
}

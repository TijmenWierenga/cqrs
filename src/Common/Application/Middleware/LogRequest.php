<?php

namespace TijmenWierenga\Project\Common\Application\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamData;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class LogRequest implements Middleware
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LogRequest constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param array ...$params
     */
    public function handle(ServerRequestInterface $request, StreamData $streamData, ...$params): void
    {
        $this->logger->info("Incoming request", [
            $request->getHeaders()
        ]);
    }
}

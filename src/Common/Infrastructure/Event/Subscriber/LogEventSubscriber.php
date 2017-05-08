<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Event\Subscriber;

use Psr\Log\LoggerInterface;
use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventSubscriber;
use TijmenWierenga\Project\Common\Infrastructure\Bootstrap\App;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class LogEventSubscriber implements DomainEventSubscriber
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LogEventSubscriber constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handles a domain event
     *
     * @param DomainEvent $domainEvent
     */
    public function handle(DomainEvent $domainEvent): void
    {
        $this->logger->info('Logged domain event', [
            'event' => get_class($domainEvent),
            'env' => App::environment()
        ]);
    }

    /**
     * Checks whether the subscriber is subscribed to an event
     *
     * @param DomainEvent $domainEvent
     * @return bool
     */
    public function isSubscribedTo(DomainEvent $domainEvent): bool
    {
        return true;
    }
}

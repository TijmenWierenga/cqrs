<?php
namespace TijmenWierenga\Project\Common\Domain\Event;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class DomainEventPublisher
{
    /**
     * @var self
     */
    private static $instance;

    /**
     * @var DomainEventSubscriber[]
     */
    private $subscribers = [];

    /**
     * @return DomainEventPublisher
     */
    public static function instance(): self
    {
        if (! static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * @param DomainEventSubscriber $subscriber
     */
    public function subscribe(DomainEventSubscriber $subscriber): void
    {
        $this->subscribers[] = $subscriber;
    }

    /**
     * @param DomainEvent $event
     */
    public function publish(DomainEvent $event): void
    {
        foreach ($this->subscribers as $subscriber) {
            if ($subscriber->isSubscribedTo($event)) {
                $subscriber->handle($event);
            }
        }
    }
}

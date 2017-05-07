<?php
namespace TijmenWierenga\Project\Tests\Common\Infrastructure\Event;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TijmenWierenga\Project\Common\Domain\Event\DomainEvent;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventPublisher;
use TijmenWierenga\Project\Common\Domain\Event\DomainEventSubscriber;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class DomainEventPublisherTest extends TestCase
{
    /**
     * @test
     */
    public function it_subscribes_domain_event_subscribers()
    {
    	$publisher = new DomainEventPublisher();
    	/** @var DomainEventSubscriber|PHPUnit_Framework_MockObject_MockObject $subscriber */
    	$subscriber = $this->getMockBuilder(DomainEventSubscriber::class)->getMock();

    	$publisher->subscribe($subscriber);
        $property = new \ReflectionProperty($publisher, 'subscribers');
        $property->setAccessible(true);
        $subscribers = $property->getValue($publisher);
        $property->setAccessible(false);

        $this->assertContains($subscriber, $subscribers);
    }
}

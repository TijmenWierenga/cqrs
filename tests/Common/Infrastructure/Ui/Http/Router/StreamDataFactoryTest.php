<?php

namespace TijmenWierenga\Project\Tests\Common\Infrastructure\Ui\Http\Router;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Psr\Http\Message\ServerRequestInterface;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamData;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamDataFactory;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class StreamDataFactoryTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_stream_data_from_a_json_request()
    {
        /** @var ServerRequestInterface|PHPUnit_Framework_MockObject_MockObject $request */
        $request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
        $payload = json_encode(['name' => 'Tijmen']);

        $request->expects($this->once())
            ->method('hasHeader')
            ->with('Content-Type')
            ->willReturn(true);

        $request->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn('application/json');

        $streamData = StreamDataFactory::decode($request, $payload);

        $this->assertInstanceOf(StreamData::class, $streamData);
        $this->assertEquals('Tijmen', $streamData->get('name'));
    }
}

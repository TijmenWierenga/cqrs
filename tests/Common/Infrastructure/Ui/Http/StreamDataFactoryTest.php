<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class StreamDataFactoryTest extends TestCase
{
    /**
     * @var ServerRequestInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $request;

    public function setUp()
    {
        $this->request = $this->getMockBuilder(ServerRequestInterface::class)->getMock();
    }

    /**
     * @test
     */
    public function it_throws_exception_when_content_type_header_is_missing()
    {
        $this->expectException(StreamDataException::class);

        $this->request->expects($this->once())
            ->method('hasHeader')
            ->with('Content-Type')
            ->willReturn(false);

        StreamDataFactory::decode($this->request, null);
    }

    /**
     * @test
     */
    public function it_creates_stream_data_from_json_http_request()
    {
        $data = json_encode([
            'name' => 'Tijmen',
            'age' => 30
        ]);

        $this->request->expects($this->once())
            ->method('hasHeader')
            ->with('Content-Type')
            ->willReturn(true);

        $this->request->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn('application/json');

        $streamData = StreamDataFactory::decode($this->request, $data);

        $this->assertInstanceOf(StreamData::class, $streamData);
        $this->assertEquals('Tijmen', $streamData->get('name'));
        $this->assertEquals(30, $streamData->get('age'));
    }

    /**
     * @test
     */
    public function it_creates_stream_data_from_an_empty_stream()
    {
        $this->request->expects($this->once())
            ->method('hasHeader')
            ->with('Content-Type')
            ->willReturn(true);

        $this->request->expects($this->once())
            ->method('getHeader')
            ->with('Content-Type')
            ->willReturn('application/json');

        $streamData = StreamDataFactory::decode($this->request, null);

        $this->assertInstanceOf(StreamData::class, $streamData);
        $this->assertNull($streamData->get('name'));
    }
}

<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\ServerRequest;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class ResponseFactoryTest extends TestCase
{
    /**
     * @test
     * @dataProvider factoryProvider
     * @param ServerRequestInterface $request
     * @param HttpResponse $serviceResponse
     */
    public function it_creates_a_response_based_on_the_accept_header(
        ServerRequestInterface $request,
        HttpResponse $serviceResponse
    ) {
    	$response = ResponseFactory::generate($request, $serviceResponse);

    	$this->assertInstanceOf(ResponseInterface::class, $response);
    	$this->assertEquals('application/json', $response->getHeader('Content-Type')[0]);
    	$this->assertJson((string) $response->getBody());
    	$this->assertArraySubset([
    	    "data" => [
                "name" => "Tijmen",
                "age" => 30
            ]
        ], json_decode((string) $response->getBody(), true));
    	$this->assertEquals($serviceResponse->getStatusCode(), $response->getStatusCode());
    }

    public function factoryProvider(): array
    {
        $serviceResponse = new class implements HttpResponse {
            private $statusCode;
            private $headers;
            private $data;

            /**
             *  constructor.
             * @param int $statusCode
             * @param array $headers
             * @param array $data
             */
            public function __construct($statusCode = 200, array $headers = [], array $data = [
                "name" => "Tijmen",
                "age" => 30
            ])
            {
                $this->statusCode = $statusCode;
                $this->headers = $headers;
                $this->data = $data;
            }

            public function getStatusCode(): int
            {
                return $this->statusCode;
            }

            public function getHeaders(): array
            {
                return $this->headers;
            }

            public function getData(): array
            {
                return $this->data;
            }
        };

        return [
            [
                new ServerRequest("GET", "/"),
                new $serviceResponse
            ], [
            new ServerRequest("GET", "/", ["Accept" => "application/json"]),
                new $serviceResponse(400)
            ], [
                new ServerRequest("POST", "/", ["Accept" => "application/json"]),
                new $serviceResponse(201)
            ]
        ];
    }
}

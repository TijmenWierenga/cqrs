<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

use Assert\Assertion;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class Route 
{
    const GET = 'GET';
    const POST = 'POST';
    const PUT = 'PUT';
    const DELETE = 'DELETE';
    const METHODS = [
        self::GET, self::POST, self::PUT, self::DELETE
    ];

    /**
     * @var string
     */
    private $httpMethod;
    /**
     * @var string
     */
    private $uri;

    /**
     * Route constructor.
     * @param string $httpMethod
     * @param string $uri
     */
    public function __construct(string $httpMethod, string $uri)
    {
        Assertion::inArray(strtoupper($httpMethod), self::METHODS);

        $this->httpMethod = $httpMethod;
        $this->uri = UriHelper::format($uri);
    }

    /**
     * @return string
     */
    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }
}

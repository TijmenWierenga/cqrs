<?php
namespace TijmenWierenga\Project\Account\Application\Service\User;

use Psr\Http\Message\ServerRequestInterface;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpRequest;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamData;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class RetrieveUserRequest implements HttpRequest
{
    /**
     * @var string
     */
    private $userId;

    /**
     * RetrieveUserRequest constructor.
     * @param string $userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * Generates a Service Request from a HttpRequest (ServerRequestInterface)
     *
     * @param ServerRequestInterface $request
     * @param StreamData $streamData
     * @param array $routeVars
     * @return HttpRequest
     */
    public static function createFromHttpRequest(
        ServerRequestInterface $request,
        StreamData $streamData,
        array $routeVars
    ) {
        return new self($routeVars['id']);
    }
}

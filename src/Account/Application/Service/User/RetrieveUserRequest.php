<?php
namespace TijmenWierenga\Project\Account\Application\Service\User;

use Psr\Http\Message\ServerRequestInterface;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpRequest;

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
     * @return HttpRequest
     */
    public static function createFromHttpRequest(ServerRequestInterface $request) {
        return new self($request->getAttribute('route')->getRouteVars()->get('id'));
    }
}

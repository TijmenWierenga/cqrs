<?php
namespace TijmenWierenga\Project\Account\Application\Service\User;

use TijmenWierenga\Project\Account\Domain\Model\User\User;
use TijmenWierenga\Project\Common\Application\Service\ServiceResponse;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpResponse;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class RegisterUserResponse extends ServiceResponse implements HttpResponse
{
    /**
     * RegisterUserResponse constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct(201, $user);
    }
}

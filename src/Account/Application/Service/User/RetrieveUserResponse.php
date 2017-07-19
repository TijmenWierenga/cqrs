<?php

namespace TijmenWierenga\Project\Account\Application\Service\User;

use TijmenWierenga\Project\Common\Application\Service\ServiceResponse;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpResponse;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class RetrieveUserResponse extends ServiceResponse implements HttpResponse
{
    /**
     * RetrieveUserResponse constructor.
     * @param mixed $user
     */
    public function __construct($user)
    {
        parent::__construct(200, $user);
    }
}

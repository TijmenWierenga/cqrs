<?php

namespace TijmenWierenga\Project\Common\Application\Service;

use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpResponse;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class HealthcheckResponse extends ServiceResponse implements HttpResponse
{
    /**
     * HealthcheckResponse constructor.
     */
    public function __construct()
    {
        parent::__construct(self::HTTP_OK, ["Healthcheck OK!"]);
    }
}

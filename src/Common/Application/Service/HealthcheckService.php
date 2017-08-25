<?php

namespace TijmenWierenga\Project\Common\Application\Service;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
final class HealthcheckService
{
    /**
     * @return HealthcheckResponse
     */
    public function check(): HealthcheckResponse
    {
        return new HealthcheckResponse();
    }
}

<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Bootstrap;

use RuntimeException;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class EnvironmentException extends RuntimeException
{
    public static function invalidEnvironment(string $environment): self
    {
        return new self("
        Invalid environment specified. Expected: " . implode(', ', App::ENVIRONMENTS) . "
        Got: {$environment}
        ");
    }
}

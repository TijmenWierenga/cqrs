<?php
namespace TijmenWierenga\Project\Common\Domain\Projection;

use RuntimeException;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class ProjectionException extends RuntimeException
{
    /**
     * @param string $eventClass
     * @return ProjectionException
     */
    public static function noProjectionConfiguredForEvent(string $eventClass): self
    {
        return new self("No projection configured for domain event: {$eventClass}");
    }
}

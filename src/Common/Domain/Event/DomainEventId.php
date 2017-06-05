<?php
namespace TijmenWierenga\Project\Common\Domain\Event;

use Ramsey\Uuid\Uuid;
use TijmenWierenga\Project\Timesheets\Domain\Model\Identifier\Id;
use TijmenWierenga\Project\Timesheets\Domain\Model\Identifier\RootId;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class DomainEventId extends RootId implements Id
{
    public static function new(): Id
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $uuid): Id
    {
        return new self(Uuid::fromString($uuid));
    }
}

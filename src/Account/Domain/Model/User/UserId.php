<?php
namespace TijmenWierenga\Project\Account\Domain\Model\User;

use Ramsey\Uuid\Uuid;
use TijmenWierenga\Project\Timesheets\Domain\Model\Identifier\Id;
use TijmenWierenga\Project\Timesheets\Domain\Model\Identifier\RootId;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserId extends RootId implements Id
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

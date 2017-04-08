<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Model\Identifier;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
abstract class RootId implements Id
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * WorkLogId constructor.
     * @param UuidInterface $id
     */
    protected function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public function __toString(): string
    {
        return $this->id->toString();
    }

    abstract public static function new(): Id;
    abstract public static function fromString(string $uuid): Id;
}

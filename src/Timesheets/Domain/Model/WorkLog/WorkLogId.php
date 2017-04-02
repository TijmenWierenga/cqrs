<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog;

use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use TijmenWierenga\Project\Timesheets\Domain\Model\Identifier\Id;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class WorkLogId implements Id
{
    /**
     * @var UuidInterface
     */
    private $id;

    /**
     * WorkLogId constructor.
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    public static function new(): Id
    {
        return new self(Uuid::uuid4());
    }
}

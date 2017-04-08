<?php
namespace TijmenWierenga\Project\Tests\Timesheets\Domain\Model\WorkLog;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\UuidInterface;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogId;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class WorkLogIdTest extends TestCase
{
    /**
     * @test
     * @return WorkLogId
     */
    public function it_generates_a_new_work_log_id(): WorkLogId
    {
    	$id = WorkLogId::new();

    	$this->assertInstanceOf(WorkLogId::class, $id);

    	return $id;
    }

    /**
     * @test
     * @depends it_generates_a_new_work_log_id
     * @param WorkLogId $id
     * @return string
     */
    public function it_casts_a_work_log_id_to_string(WorkLogId $id): string
    {
    	$this->assertInternalType('string', (string) $id);

    	return (string) $id;
    }

    /**
     * @test
     * @depends it_casts_a_work_log_id_to_string
     * @param string $uuid
     */
    public function it_can_create_a_work_log_id_from_string(string $uuid)
    {
        $workLog = WorkLogId::fromString($uuid);

    	$this->assertInstanceOf(WorkLogId::class, $workLog);
    	$this->assertEquals($uuid, (string) $workLog);
    }
}

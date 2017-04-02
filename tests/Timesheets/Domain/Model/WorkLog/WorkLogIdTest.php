<?php
namespace TijmenWierenga\Project\Tests\Timesheets\Domain\Model\WorkLog;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Timesheets\Domain\Model\WorkLog\WorkLogId;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class WorkLogIdTest extends TestCase
{
    /**
     * @test
     */
    public function it_generates_a_new_work_log_id()
    {
    	$id = WorkLogId::new();

    	$this->assertInstanceOf(WorkLogId::class, $id);
    }
}

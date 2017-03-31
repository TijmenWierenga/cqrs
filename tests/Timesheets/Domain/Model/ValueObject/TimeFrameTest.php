<?php

namespace TijmenWierenga\Project\Tests\Timesheets\Domain\Model\ValueObject;

use DateInterval;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Timesheets\Domain\Model\ValueObject\TimeFrame;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class TimeFrameTest extends TestCase
{
    /**
     * @test
     */
    public function it_creates_a_new_time_frame()
    {
        $start = new DateTimeImmutable("2017-03-31T08:00:00");
        $end = new DateTimeImmutable("2017-03-31T17:00:00");
        $timeFrame = TimeFrame::new($start, $end);

        $this->assertInstanceOf(TimeFrame::class, $timeFrame);

        return $timeFrame;
    }

    /**
     * @test
     * @depends it_creates_a_new_time_frame
     * @param TimeFrame $timeFrame
     */
    public function it_calculates_the_duration_of_a_time_frame(TimeFrame $timeFrame)
    {
        $duration = $timeFrame->duration();

        $this->assertInstanceOf(DateInterval::class, $duration);
        $this->assertEquals(9, (int) $duration->format('%H'));
    }
}

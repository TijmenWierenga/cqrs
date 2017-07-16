<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use PHPUnit\Framework\TestCase;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class StreamDataTest extends TestCase
{
    /**
     * @test
     */
    public function it_gets_data_by_key()
    {
        $streamData = new StreamData([
            'name' => 'Tijmen'
        ]);

        $this->assertEquals('Tijmen', $streamData->get('name'));
    }
}

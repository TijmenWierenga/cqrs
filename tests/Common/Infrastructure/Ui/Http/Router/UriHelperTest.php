<?php
namespace TijmenWierenga\Project\Tests\Common\Infrastructure\Ui\Http\Router;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\UriHelper;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UriHelperTest extends TestCase
{
    /**
     * @test
     */
    public function it_formats_a_uri_correctly_so_router_can_handle_it()
    {
        $expected = '/testing/';
    	$this->assertEquals($expected, UriHelper::format('testing'));
        $this->assertEquals($expected, UriHelper::format('testing/'));
        $this->assertEquals($expected, UriHelper::format('testing//'));
        $this->assertEquals($expected, UriHelper::format('/testing'));
        $this->assertEquals($expected, UriHelper::format('//testing'));
        $this->assertEquals($expected, UriHelper::format('/testing/'));
        $this->assertEquals($expected, UriHelper::format('//testing//'));
    }

    /**
     * @test
     */
    public function it_strips_the_query_of_a_uri()
    {
    	$this->assertEquals('/testing/', UriHelper::stripQuery('/testing?var=this'));
    }
}

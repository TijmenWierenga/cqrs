<?php
namespace TijmenWierenga\Project\Tests\Common\Infrastructure\Ui\Http\Router;

use Assert\InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router\RouteVars;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RouteVarsTest extends TestCase
{
    /**
     * @test
     */
    public function it_only_allows_string_key_value_pairs()
    {
        $this->expectException(InvalidArgumentException::class);

    	new RouteVars([
    	    "id" => true
        ]);
    }

    /**
     * @test
     */
    public function it_returns_null_if_key_does_not_exist()
    {
    	$routeVars = new RouteVars([]);

    	$this->assertNull($routeVars->get('id'));
    }

    /**
     * @test
     */
    public function it_builds_a_collection_of_route_vars(): RouteVars
    {
    	$parameters = [
    	    "id" => "tijmen-22-10-1986",
            "type" => "developer"
        ];

    	$routeVars = new RouteVars($parameters);

    	$this->assertEquals("tijmen-22-10-1986", $routeVars->get('id'));
    	$this->assertEquals("developer", $routeVars->get('type'));

    	return $routeVars;
    }

    /**
     * @test
     * @depends it_builds_a_collection_of_route_vars
     * @param RouteVars $routeVars
     */
    public function it_can_access_route_vars_as_array(RouteVars $routeVars)
    {
    	$this->assertEquals("developer", $routeVars['type']);
    	$this->assertEquals("tijmen-22-10-1986", $routeVars['id']);
    }
}

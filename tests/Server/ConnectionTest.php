<?php
namespace TijmenWierenga\Project\Tests\Server;

use PHPUnit\Framework\TestCase;
use TijmenWierenga\Server\Connection;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class ConnectionTest extends TestCase
{
    /**
     * @test
     */
    public function it_instantiates_a_connection_with_default_params()
    {
    	$connection = new Connection();

    	$this->assertEquals(Connection::DEFAULT_PORT, $connection->getPort());
    	$this->assertEquals(Connection::DEFAULT_IP_ADDRESS, $connection->getIpAddress());

    	return $connection;
    }

    /**
     * @test
     * @depends it_instantiates_a_connection_with_default_params
     * @param Connection $connection
     */
    public function it_casts_a_connection_to_string(Connection $connection)
    {
    	$this->assertEquals(
    	    Connection::DEFAULT_IP_ADDRESS . ':' . Connection::DEFAULT_PORT,
            (string) $connection
        );
    }

    /**
     * @test
     */
    public function it_instantiates_a_connection_on_a_different_port()
    {
    	$connection = new Connection(80);

    	$this->assertEquals(80, $connection->getPort());
    	$this->assertEquals(Connection::DEFAULT_IP_ADDRESS, $connection->getIpAddress());
    }

    /**
     * @test
     */
    public function it_instantiates_a_connection_with_a_different_ip_address()
    {
    	$connection = new Connection(80, '127.0.0.1');

    	$this->assertEquals(80, $connection->getPort());
    	$this->assertEquals('127.0.0.1', $connection->getIpAddress());
    }
}

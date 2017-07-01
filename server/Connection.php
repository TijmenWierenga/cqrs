<?php
namespace TijmenWierenga\Server;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class Connection
{
    /**
     * @var string
     */
    private $ipAddress;
    /**
     * @var int
     */
    private $port;

    /**
     * Connection constructor.
     * @param string $ipAddress
     * @param int $port
     */
    public function __construct(string $ipAddress = '0.0.0.0', int $port = 1337)
    {
        $this->ipAddress = $ipAddress;
        $this->port = $port;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    public function __toString(): string
    {
        return $this->ipAddress . ":" . $this->port;
    }
}

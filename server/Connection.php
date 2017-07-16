<?php
namespace TijmenWierenga\Server;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class Connection
{
    const DEFAULT_PORT = 1337;
    const DEFAULT_IP_ADDRESS = '0.0.0.0';

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
    public function __construct(int $port = self::DEFAULT_PORT, string $ipAddress = self::DEFAULT_IP_ADDRESS)
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

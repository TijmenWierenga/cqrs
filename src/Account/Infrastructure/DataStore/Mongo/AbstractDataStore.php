<?php
namespace TijmenWierenga\Project\Account\Infrastructure\DataStore\Mongo;

use MongoDB\Client;
use MongoDB\Collection;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
abstract class AbstractDataStore
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * AbstractDataStore constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->collection = $this->client->{$this->getNamespace()}->{$this->getCollection()};
    }

    abstract public function getNamespace(): string;
    abstract public function getCollection(): string;
}

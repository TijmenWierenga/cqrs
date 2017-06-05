<?php
namespace TijmenWierenga\Project\Account\Infrastructure\DataStore\Mongo;

use MongoDB\Client;
use TijmenWierenga\Project\Account\Domain\Model\User\UserDataStore as UserDataStoreInterface;
use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserDataStore implements UserDataStoreInterface
{
    /**
     * @var Client
     */
    private $client;

    /**
     * UserDataStore constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Finds a User by email
     *
     * @param Email $email
     * @return bool
     */
    public function emailAlreadyExists(Email $email): bool
    {
        $collection = $this->client->project->users;
        $user = $collection->findOne(['email' => (string) $email]);

        return !! $user;
    }
}

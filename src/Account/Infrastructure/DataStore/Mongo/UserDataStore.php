<?php
namespace TijmenWierenga\Project\Account\Infrastructure\DataStore\Mongo;

use MongoDB\Client;
use MongoDB\Collection;
use TijmenWierenga\Project\Account\Domain\Model\User\UserDataStore as UserDataStoreInterface;
use TijmenWierenga\Project\Account\Domain\Model\User\UserId;
use TijmenWierenga\Project\Account\Domain\Model\ValueObject\Email;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UserDataStore implements UserDataStoreInterface
{
    const NAMESPACE = 'project';
    const COLLECTION = 'users';

    /**
     * @var Client
     */
    private $client;

    /**
     * @var Collection
     */
    private $collection;

    /**
     * UserDataStore constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->collection = $this->client->{self::NAMESPACE}->{self::COLLECTION};
    }

    /**
     * Finds a User by email
     *
     * @param Email $email
     * @return bool
     */
    public function emailAlreadyExists(Email $email): bool
    {
        $user = $this->collection->findOne(['email' => (string) $email]);

        return !! $user;
    }

    /**
     * Finds a user by Id
     *
     * @param UserId $userId
     * @return mixed
     */
    public function find(UserId $userId)
    {
        return $this->collection->findOne(['_id' => (string) $userId]);
    }
}

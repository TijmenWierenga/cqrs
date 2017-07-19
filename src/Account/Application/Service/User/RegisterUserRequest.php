<?php
namespace TijmenWierenga\Project\Account\Application\Service\User;

use Psr\Http\Message\ServerRequestInterface;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpRequest;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\StreamData;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RegisterUserRequest implements HttpRequest
{
    /**
     * @var string
     */
    private $firstName;
    /**
     * @var string
     */
    private $lastName;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;

    /**
     * RegisterUserRequest constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     */
    public function __construct(
        string $firstName,
        string $lastName,
        string $email,
        string $password
    ) {
    
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Generates a Service Request from a HttpRequest (ServerRequestInterface)
     *
     * @param ServerRequestInterface $request
     * @param StreamData $data
     * @param array $vars
     * @return RegisterUserRequest
     */
    public static function createFromHttpRequest(ServerRequestInterface $request, StreamData $data, array $vars): self
    {
        return new self(
            $data->get('first_name'),
            $data->get('last_name'),
            $data->get('email'),
            $data->get('password')
        );
    }
}

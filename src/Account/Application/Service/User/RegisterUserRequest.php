<?php
namespace TijmenWierenga\Project\Account\Application\Service\User;

use Psr\Http\Message\ServerRequestInterface;
use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpRequest;

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
     * @return self
     */
    public static function createFromHttpRequest(ServerRequestInterface $request): self
    {
        // TODO: Remove hardcoded values and use ServerRequest

        return new self(
            'Tijmen',
            'Wierenga',
            'tijmen@devmob.com',
            '123456'
        );
    }
}

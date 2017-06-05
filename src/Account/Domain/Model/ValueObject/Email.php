<?php
namespace TijmenWierenga\Project\Account\Domain\Model\ValueObject;

use Assert\Assertion;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class Email
{
    /**
     * @var string
     */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        Assertion::email($email);
        $this->email = $email;
    }

    public function __toString(): string
    {
        return $this->email;
    }
}

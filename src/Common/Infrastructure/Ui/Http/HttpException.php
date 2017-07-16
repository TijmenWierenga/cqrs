<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use RuntimeException;

/**
 * @author  Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class HttpException extends RuntimeException
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var string
     */
    private $statusPhrase;
    /**
     * @var array
     */
    private $data;

    /**
     * HttpException constructor.
     * @param int $statusCode
     * @param string $statusPhrase
     * @param array|null $data
     */
    public function __construct(int $statusCode, string $statusPhrase, ?array $data = null)
    {
        $this->statusCode = $statusCode;
        $this->statusPhrase = $statusPhrase;
        $this->data = $data;

        parent::__construct($statusPhrase);
    }

    /**
     * @return HttpException
     */
    public static function notFound(): self
    {
        /** TODO: Fetch HTTP Status codes from class constants */
        return new self(404, "Not found");
    }

    /**
     * @param array $allowedMethods
     * @return HttpException
     */
    public static function methodNotAllowed(array $allowedMethods): self
    {
        /** TODO: Fetch HTTP Status codes from class constants */
        return new self(405, "Method not allowed", [
            "allowed_methods" => $allowedMethods
        ]);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusPhrase(): string
    {
        return $this->statusPhrase;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}

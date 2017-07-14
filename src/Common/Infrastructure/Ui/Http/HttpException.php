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
     * HttpException constructor.
     * @param int $statusCode
     * @param string $statusPhrase
     */
    public function __construct(int $statusCode, string $statusPhrase)
    {
        $this->statusCode = $statusCode;

        parent::__construct($statusPhrase);
        $this->statusPhrase = $statusPhrase;
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
     * @return HttpException
     */
    public static function methodNotAllowed(): self
    {
        /** TODO: Fetch HTTP Status codes from class constants */
        return new self(405, "Method not allowed");
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
}
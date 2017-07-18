<?php
namespace TijmenWierenga\Project\Common\Application\Service;

use TijmenWierenga\Project\Common\Infrastructure\Ui\Http\HttpResponse;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
abstract class ServiceResponse implements HttpResponse
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var
     */
    private $data;
    /**
     * @var array
     */
    private $headers;

    /**
     * ServiceResponse constructor.
     * @param int $statusCode
     * @param $data
     * @param array $headers
     */
    protected function __construct(int $statusCode, $data, array $headers = [])
    {
        $this->statusCode = $statusCode;
        $this->data = $data;
        $this->headers = $headers;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }
}

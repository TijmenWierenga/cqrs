<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
interface HttpResponse
{
    /**
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return array
     */
    public function getHeaders(): array;
}

<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Lukasoppermann\Httpstatus\Httpstatuscodes as HttpStatusCodes;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
interface HttpResponse extends HttpStatusCodes
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

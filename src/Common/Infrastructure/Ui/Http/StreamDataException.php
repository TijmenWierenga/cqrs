<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use RuntimeException;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class StreamDataException extends RuntimeException
{
    /**
     * @return StreamDataException
     */
    public static function missingContentTypeHeader(): self
    {
        return new self("Could not generate StreamData. Missing Content-Type header");
    }
}

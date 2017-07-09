<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class StreamDataFactory
{
    /**
     * @param ServerRequestInterface $request
     * @param $data
     * @return StreamData
     * @throws StreamDataException
     */
    public static function decode(ServerRequestInterface $request, $data): StreamData
    {
        if (! $request->hasHeader('Content-Type')) {
            throw StreamDataException::missingContentTypeHeader();
        }

        switch ($request->getHeader('Content-Type')) {
            default:
            case 'application/json':
                $streamData = self::parseJson($data);
                break;
        }

        return $streamData;
    }

    /**
     * @param $data
     * @return StreamData
     */
    private static function parseJson($data): StreamData
    {
        return new StreamData(json_decode($data, true));
    }
}

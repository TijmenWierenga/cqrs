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
    public static function decode(ServerRequestInterface $request, $data = null): StreamData
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
        $data = json_decode($data, true);

        /** Cast data to empty array when there is no data available */
        if (! $data) {
            $data = [];
        }

        return new StreamData($data);
    }
}

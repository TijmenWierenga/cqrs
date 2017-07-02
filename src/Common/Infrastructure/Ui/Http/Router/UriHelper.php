<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class UriHelper
{
    public static function format(string $uri): string
    {
        return '/' . trim($uri, '/') . '/';
    }

    public static function stripQuery(string $uri): string
    {
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        return self::format(rawurldecode($uri));
    }
}

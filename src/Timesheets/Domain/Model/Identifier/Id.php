<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Model\Identifier;

interface Id
{
    /**
     * @return Id
     */
    public static function new(): Id;

    /**
     * @param string $uuid
     * @return Id
     */
    public static function fromString(string $uuid): Id;
}

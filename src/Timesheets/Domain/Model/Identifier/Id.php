<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Model\Identifier;

interface Id
{
    /**
     * Generate a new ID
     *
     * @return self;
     */
    public static function new(): Id;
}

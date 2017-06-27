<?php
namespace TijmenWierenga\Server;


interface Server
{
    /**
     * Start a new server
     */
    public function run(): void;
}

<?php
namespace TijmenWierenga\Project\Common\Domain\Model\File;

use Assert\Assertion;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class File 
{
    /**
     * @var string
     */
    private $path;

    /**
     * File constructor.
     * @param string $path
     */
    public function __construct(string $path)
    {
        Assertion::file($path);
        $this->path = $path;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
}

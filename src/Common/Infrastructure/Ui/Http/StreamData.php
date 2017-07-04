<?php

namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http;

/**
 * @author Tijmen Wierenga <tijmen.wierenga@devmob.com>
 */
class StreamData
{
    /**
     * @var array
     */
    private $data;

    /**
     * StreamData constructor.
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $param
     * @return mixed|null
     */
    public function get(string $param)
    {
        if (! array_key_exists($param, $this->data)) {
            return null;
        }

        return $this->data[$param];
    }
}

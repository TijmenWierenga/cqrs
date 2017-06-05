<?php
namespace TijmenWierenga\Project\Common\Domain\Exception;

use RuntimeException;
use TijmenWierenga\Project\Timesheets\Domain\Model\Identifier\Id;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class ModelNotFoundException extends RuntimeException
{
    /**
     * @var string
     */
    private $model;

    /**
     * ModelNotFoundException constructor.
     * @param string $model
     * @param string $message
     */
    public function __construct(string $model, string $message)
    {
        $this->model = $model;
        $this->message = $message;
    }

    public static function byId(string $model, Id $id): self
    {
        return new self($model, "{$model}\\{$id} could not be found");
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }
}

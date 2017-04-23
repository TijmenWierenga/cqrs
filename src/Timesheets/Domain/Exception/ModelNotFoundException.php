<?php
namespace TijmenWierenga\Project\Timesheets\Domain\Exception;

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
     * @var Id
     */
    private $id;

    /**
     * ModelNotFoundException constructor.
     * @param string $model
     * @param Id $id
     */
    public function __construct(string $model, Id $id)
    {
        $this->model = $model;
        $this->id = $id;

        parent::__construct(
            "{$model}\\{$id} could not be found"
        );
    }
}

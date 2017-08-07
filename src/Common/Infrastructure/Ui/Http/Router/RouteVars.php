<?php
namespace TijmenWierenga\Project\Common\Infrastructure\Ui\Http\Router;

use ArrayAccess;
use Assert\Assertion;

/**
 * @author Tijmen Wierenga <t.wierenga@live.nl>
 */
class RouteVars implements ArrayAccess
{
    /**
     * @var iterable
     */
    private $vars;

    /**
     * RouteVars constructor.
     * @param iterable $vars
     */
    public function __construct(iterable $vars)
    {
        Assertion::allString($vars);
        $this->vars = $vars;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function get(string $key): ?string
    {
        return $this->offsetGet($key);
    }

    /**
     * Whether a offset exists
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     * An offset to check for.
     * </p>
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->vars);
    }

    /**
     * Offset to retrieve
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     * The offset to retrieve.
     * </p>
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        if (! $this->offsetExists($offset)) {
            return null;
        }

        return $this->vars[$offset];
    }

    /**
     * Offset to set
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     * The offset to assign the value to.
     * </p>
     * @param mixed $value <p>
     * The value to set.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->vars[$offset] = $value;
    }

    /**
     * Offset to unset
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     * The offset to unset.
     * </p>
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset)
    {
        unset($this->vars[$offset]);
    }
}

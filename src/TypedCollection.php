<?php
declare(strict_types=1);

namespace OwlLabs\Type;

/**
 * Class TypedCollection
 * @package OwlLabs\Type
 */
class TypedCollection implements \Countable, \IteratorAggregate, \ArrayAccess
{
    use Library\Typing;

    /**
     * @var string
     */
    private $type;

    /**
     * @var array
     */
    private $data = [];

    /**
     * TypedCollection constructor.
     * @param string $type
     * @param array $initialData
     */
    public function __construct(string $type, array $initialData = [])
    {
        if (!$this->isValidType($type)) {
            throw new Exception\InvalidType('Collection type cannot be empty');
        }
        if (!$this->isValidArray($type, $initialData)) {
            throw new Exception\InvalidData('Array has elements of wrong type');
        }
        $this->type = $type;
        $this->data = array_values($initialData);
    }

    /**
     * @param int $key
     * @return bool
     */
    public function exists(int $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @param int $key
     * @param mixed $value
     * @return TypedCollection
     */
    public function withValue(int $key, $value): TypedCollection
    {
        if (!$this->exists($key)) {
            throw new Exception\NotExistingKey('Key ' . $key . ' does not exist');
        }
        $data = $this->data;
        $data[$key] = $value;
        return new self($this->type, $data);
    }

    /**
     * @param int $key
     * @return TypedCollection
     */
    public function withoutValue(int $key): TypedCollection
    {
        if (!$this->exists($key)) {
            throw new Exception\NotExistingKey('Key ' . $key . ' does not exist');
        }
        $data = $this->data;
        unset($data[$key]);
        return new self($this->type, $data);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data);
    }

    /**
     * @param mixed $offset
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return $this->exists($offset);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @see TypedCollection::set
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * @throws Exception\MutatedState Always thrown, TypedCollection is immutable
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception\MutatedState('Cannot set a value via array access, use "set" method');
    }

    /**
     * @see TypedCollection::unset
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw new Exception\MutatedState('Cannot unset a value via array access, use "unset" method');
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }
}

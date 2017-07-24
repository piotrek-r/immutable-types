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
    public function indexExists(int $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * @param int $index
     * @param mixed $value
     * @return TypedCollection
     */
    public function withValueAtIndex(int $index, $value): TypedCollection
    {
        if (!$this->indexExists($index)) {
            throw new Exception\NotExistingKey('Index ' . $index . ' does not exist');
        }
        $data = $this->data;
        $data[$index] = $value;
        return new self($this->type, $data);
    }

    /**
     * @param int $index
     * @return TypedCollection
     */
    public function withoutIndex(int $index): TypedCollection
    {
        if (!$this->indexExists($index)) {
            throw new Exception\NotExistingKey('Index ' . $index . ' does not exist');
        }
        $data = $this->data;
        unset($data[$index]);
        return new self($this->type, $data);
    }

    /**
     * @param mixed $element
     * @return TypedCollection
     */
    public function withValue($element): TypedCollection
    {
        if (!$this->isValidElement($this->type, $element)) {
            throw new Exception\InvalidData('Wrong element type: ' . $this->getType($element));
        }
        $data = $this->data;
        array_push($data, $element);
        return new self($this->type, $data);
    }

    /**
     * @param mixed $element
     * @return TypedCollection
     */
    public function withValueAtBeginning($element)
    {
        if (!$this->isValidElement($this->type, $element)) {
            throw new Exception\InvalidData('Wrong element type: ' . $this->getType($element));
        }
        $data = $this->data;
        array_unshift($data, $element);
        return new self($this->type, $data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->getData();
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->getData());
    }

    /**
     * @param mixed $offset
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset)
    {
        return $this->indexExists($offset);
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
     * @see TypedCollection::withValueAtIndex
     * @param mixed $offset
     * @param mixed $value
     * @return void
     * @throws Exception\MutatedState Always thrown, TypedCollection is immutable
     */
    public function offsetSet($offset, $value)
    {
        throw new Exception\MutatedState('Cannot set a value via array access, use "withValueAtIndex" method');
    }

    /**
     * @see TypedCollection::withoutIndex
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        throw new Exception\MutatedState('Cannot unset a value via array access, use "withoutIndex" method');
    }

    /**
     * @return int
     */
    public function count()
    {
        return count($this->data);
    }
}

<?php
declare(strict_types=1);

namespace PiotrekR\Type;

/**
 * Immutable wrapper for a boolean type
 *
 * @package PiotrekR\Type
 */
class Boolean implements \JsonSerializable
{
    /**
     * @var bool
     */
    private $value;

    /**
     * Boolean constructor.
     * @param bool $value
     */
    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    /**
     * @return bool
     */
    public function value(): bool
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function jsonSerialize()
    {
        return $this->value();
    }

    /**
     * @return Boolean
     */
    public function invert(): Boolean
    {
        return new static(!$this->value());
    }
}

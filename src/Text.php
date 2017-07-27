<?php
declare(strict_types=1);

namespace PiotrekR\Type;

/**
 * Immutable wrapper for a string type
 *
 * @package PiotrekR\Type
 */
class Text implements \JsonSerializable
{
    /**
     * @var string
     */
    private $value;

    /**
     * Text constructor.
     * @param string $value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * Objects serializes as plain string type
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->value();
    }
}

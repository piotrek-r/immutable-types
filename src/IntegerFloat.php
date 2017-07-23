<?php
declare(strict_types=1);

namespace OwlLabs\Type;

/**
 * Immutable wrapper for a float type
 *
 * @package OwlLabs\Type
 */
class IntegerFloat implements \JsonSerializable
{
    /**
     * @var float
     */
    private $value;

    /**
     * @param string $value
     * @return IntegerFloat
     */
    public static function fromString(string $value): IntegerFloat
    {
        return new self((float)$value);
    }

    /**
     * IntegerFloat constructor.
     * @param float $value
     */
    public function __construct(float $value)
    {
        $this->value = $value;
    }

    /**
     * @return float
     */
    public function value(): float
    {
        return $this->value;
    }

    /**
     * @return float
     */
    public function jsonSerialize()
    {
        return $this->value();
    }
}

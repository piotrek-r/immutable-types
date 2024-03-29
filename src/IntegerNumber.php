<?php
declare(strict_types=1);

namespace PiotrekR\Type;

/**
 * Immutable wrapper for an integer type
 *
 * @package PiotrekR\Type
 */
class IntegerNumber implements \JsonSerializable
{
    /**
     * @var int
     */
    private $value;

    /**
     * @param string $value
     * @return IntegerNumber
     */
    public static function fromString(string $value): IntegerNumber
    {
        return new static((int)$value);
    }

    /**
     * IntegerNumber constructor.
     * @param int $value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * @return int
     */
    public function value(): int
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function jsonSerialize()
    {
        return $this->value();
    }
}

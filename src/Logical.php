<?php
declare(strict_types=1);

namespace OwlLabs\Type;

/**
 * Immutable wrapper for an boolean type
 * @package OwlLabs\Type
 */
class Logical implements \JsonSerializable
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
     * @return Logical
     */
    public function invert(): Logical
    {
        return new self(!$this->value());
    }
}

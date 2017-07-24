<?php
declare(strict_types=1);

namespace OwlLabs\Type\Library;

/**
 * Trait Typing
 * @package OwlLabs\Type\Library
 */
trait Typing
{
    private static $aliases = [
        'int' => 'integer',
        'double' => 'float',
    ];

    /**
     * @param string $type
     * @return bool
     */
    protected function isValidType(string $type): bool
    {
        return !empty($type);
    }

    /**
     * @param string $type
     * @param array $elements
     * @return bool
     */
    protected function isValidArray(string $type, array $elements): bool
    {
        foreach ($elements as $element) {
            if (!$this->isValidElement($type, $element)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $expectedType
     * @param mixed $element
     * @return bool
     */
    protected function isValidElement(string $expectedType, $element): bool
    {
        $elementType = $this->getType($element);
        if ($expectedType === $elementType) {
            return true;
        }
        if (array_key_exists($expectedType, self::$aliases) && $elementType === self::$aliases[$expectedType]) {
            return true;
        }
        return false;
    }

    /**
     * @param mixed $element
     * @return string
     */
    protected function getType($element): string
    {
        return is_object($element) ? get_class($element) : gettype($element);
    }
}

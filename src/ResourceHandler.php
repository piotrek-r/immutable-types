<?php
declare(strict_types=1);

namespace OwlLabs\Type;

/**
 * Immutable wrapper for a resource type
 *
 * @package OwlLabs\Type
 */
class ResourceHandler
{
    /**
     * @var resource
     */
    private $resource;

    /**
     * @param string $filename
     * @param string $mode
     * @param bool|null $useIncludePath
     * @param mixed $context5
     * @return ResourceHandler
     */
    public function open(string $filename, string $mode, bool $useIncludePath = null, $context = null)
    {
        return new self(fopen($filename, $mode, $useIncludePath, $context));
    }

    /**
     * Resource constructor.
     * @param resource $resource
     * @throws Exception\TypeError
     */
    public function __construct($resource)
    {
        if (!is_resource($resource)) {
            throw new Exception\TypeError('Real resource must be provided');
        }
        $this->resource = $resource;
    }

    /**
     * Resource
     */
    public function __destruct()
    {
        fclose($this->resource);
    }

    /**
     * @return resource
     */
    public function resource()
    {
        return $this->resource;
    }
}
<?php

declare(strict_types=1);

namespace Stgen\Util;

use Stgen\Exception\InvalidArgumentException;

class ClassUtil
{
    /**
     * @param string $path
     * @param string $basePath
     * @param null|string $namespace
     * @return string
     * @throws InvalidArgumentException
     */
    public function pathToPSR4Name($path, $basePath, $namespace = null)
    {
        $basePath = rtrim($basePath) . '/';
        if (strpos($path, $basePath) !== 0) {
            throw new InvalidArgumentException(
                "File path `{$path}` does not corresponds to a base path `{$basePath}`."
            );
        }
        $className = substr($path, strlen($basePath), -4);
        if (!$className) {
            throw new InvalidArgumentException("Failed to detect class name from file path {$path}.");
        }
        $className = $namespace . '\\' . str_replace('/', '\\', $className);
        return $className;
    }
}

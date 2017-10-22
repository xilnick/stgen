<?php

declare(strict_types=1);

namespace Stgen\Source;

use Stgen\Source\Item\ClassSourceItem;
use Stgen\Source\Item\ISourceItem;
use Stgen\Util\ClassUtil;

/**
 * Class PSR4ClassSource
 * @package Stgen\Source
 */
class PSR4ClassSource implements ISource
{

    /**
     * @var string
     */
    private $basePath;

    /**
     * @var string
     */
    private $baseNamespace;

    /**
     * @var \Iterator
     */
    private $delegateIterator;

    /**
     * PSR4ClassSource constructor.
     * @param string $baseDir
     * @param string $baseNamespace
     */
    public function __construct(string $baseDir, $baseNamespace = null)
    {
        $this->basePath = realpath($baseDir);
        $this->baseNamespace = $baseNamespace;
        $this->delegateIterator = new \CallbackFilterIterator(
            new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($baseDir, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::LEAVES_ONLY
            ),
            function (\SplFileInfo $value) {
                return preg_match('#^[\w\d_]+\.php$#i', $value->getFilename());
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->delegateIterator->next();
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return $this->delegateIterator->key();
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->delegateIterator->valid();
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->delegateIterator->rewind();
    }

    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->currentItem();
    }

    /**
     * @inheritdoc
     */
    function currentItem(): ISourceItem
    {
        $classDetect = new ClassUtil();
        $path = realpath($this->delegateIterator->current()->getPathname());
        $class = $classDetect->pathToPSR4Name($path, $this->basePath, $this->baseNamespace);
        return new ClassSourceItem($path, $class);
    }
}

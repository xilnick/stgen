<?php

declare(strict_types=1);

namespace Stgen\Source;

use Stgen\Source\Item\ISourceItem;

class SingleFileClassSource implements ISource
{
    private $valid = true;
    /**
     * @var string
     */
    private $filePath;
    /**
     * @var string
     */
    private $className;

    /**
     * SingleFileClassSource constructor.
     * @param string $filePath
     * @param string $className
     */
    public function __construct(string $filePath, string $className)
    {
        $this->filePath = $filePath;
        $this->className = $className;
    }

    /**
     * @var ISourceItem
     */
    private $file;

    /**
     * @inheritdoc
     */
    public function next()
    {
        $this->valid = false;
    }

    /**
     * @inheritdoc
     */
    public function key()
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function valid()
    {
        return $this->valid;
    }

    /**
     * @inheritdoc
     */
    public function rewind()
    {
        $this->valid = true;
    }

    /**
     * @return ISourceItem
     */
    function current(): ISourceItem
    {
        return $this->file;
    }
}

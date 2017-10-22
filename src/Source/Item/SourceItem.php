<?php

declare(strict_types=1);

namespace Stgen\Source\Item;

abstract class SourceItem implements ISourceItem
{
    /**
     * File path where item is located.
     * @var string
     */
    private $file;

    /**
     * Value of the type represents a source.
     * @var string
     */
    private $value;

    /**
     * SourceItem constructor.
     * @param string $file
     * @param string $value
     */
    public function __construct(string $file, string $value)
    {
        $this->file = $file;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

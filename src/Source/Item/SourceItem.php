<?php

declare(strict_types=1);

namespace Stgen\Source\Item;

abstract class SourceItem implements ISourceItem
{
    /**
     * @var string
     */
    private $file;
    /**
     * @var string
     */
    private $value;

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

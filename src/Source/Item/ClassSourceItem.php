<?php

declare(strict_types=1);

namespace Stgen\Source\Item;

class ClassSourceItem extends SourceItem
{
    function getType(): string
    {
        return 'class';
    }
}

<?php

namespace Stgen\Generator;

use Stgen\Source\Item\ISourceItem;

interface IGenerateStrategy
{
    function generate(ISourceItem $source): string;
}

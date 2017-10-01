<?php

namespace Stgen\GenerateStrategy;

use Stgen\Source\Item\ISourceItem;

interface IGenerateStrategy
{
    function generate(ISourceItem $source): string;
}

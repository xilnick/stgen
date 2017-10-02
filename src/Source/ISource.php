<?php

namespace Stgen\Source;

use Stgen\Source\Item\ISourceItem;

interface ISource extends \Iterator
{
    function currentItem(): ISourceItem;
}

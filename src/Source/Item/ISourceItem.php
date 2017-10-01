<?php

namespace Stgen\Source\Item;

interface ISourceItem
{
    function getValue(): string;

    function getType(): string;

    function getFile(): string;
}

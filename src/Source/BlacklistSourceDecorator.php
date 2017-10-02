<?php

namespace Stgen\Source;

use Stgen\Source\Item\ISourceItem;

class BlacklistSourceDecorator extends \FilterIterator implements ISource
{
    /**
     * @var array
     */
    private $blacklist;

    /**
     * @var ISource
     */
    private $decorated;

    /**
     * BlacklistSourceDecorator constructor.
     * @param ISource $decorated
     * @param array $blacklist
     */
    public function __construct(ISource $decorated, array $blacklist)
    {
        parent::__construct($decorated);
        $this->blacklist = $blacklist;
        $this->decorated = $decorated;
    }

    /**
     * @inheritDoc
     */
    public function accept()
    {
        $accept = !in_array(realpath($this->currentItem()->getFile()), $this->blacklist, true);
        return $accept;
    }

    /**
     * @inheritdoc
     */
    function currentItem(): ISourceItem
    {
        return $this->decorated->currentItem();
    }
}

<?php

declare(strict_types=1);

namespace Stgen\Source;

use Stgen\Source\Item\ISourceItem;

class CompositeSource implements ISource
{
    /**
     * @var \Iterator
     */
    private $iteratorDelegate;

    /**
     * CompositeSource constructor.
     * @param ISource[] $sources
     */
    public function __construct($sources)
    {
        $this->iteratorDelegate = new \MultipleIterator();

        foreach ($sources as $source) {
            $this->iteratorDelegate->attachIterator($source);
        }
    }

    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->iteratorDelegate->next();
    }

    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->iteratorDelegate->key();
    }

    /**
     * @inheritDoc
     */
    public function valid()
    {
        return $this->iteratorDelegate->valid();
    }

    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->iteratorDelegate->rewind();
    }

    /**
     * @return ISourceItem
     */
    function current(): ISourceItem
    {
        return $this->iteratorDelegate->current();
    }
}

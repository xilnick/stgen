<?php

declare(strict_types=1);

namespace Stgen;

use Stgen\Writer\IWriter;
use Stgen\Generator\IGenerateStrategy;
use Stgen\Source\ISource;

class CodeGenerator
{
    /**
     * @var IGenerateStrategy
     */
    private $strategy;

    /**
     * @var ISource
     */
    private $source;

    /**
     * @var IWriter
     */
    private $Writer;

    /**
     * CodeGenerator constructor.
     * @param IGenerateStrategy $strategy
     * @param ISource $source
     * @param IWriter $Writer
     */
    public function __construct(
        IGenerateStrategy $strategy,
        ISource $source,
        IWriter $Writer
    )
    {
        $this->strategy = $strategy;
        $this->source = $source;
        $this->Writer = $Writer;
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        foreach ($this->source as $sourceItem) {
            try {
                $res = $this->strategy->generate($sourceItem);
            } catch (\Throwable $e) {
                continue;
            }
            $this->Writer->write($res);
        }
    }
}

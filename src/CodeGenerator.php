<?php

declare(strict_types=1);

namespace Stgen;

use Stgen\GenerateStrategy\IGenerateStrategy;
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
     * CodeGenerator constructor.
     * @param IGenerateStrategy $strategy
     * @param ISource $source
     */
    public function __construct(IGenerateStrategy $strategy, ISource $source)
    {
        $this->strategy = $strategy;
        $this->source = $source;
    }

    /**
     * todo implement result object for multi strategy generation (single file, psr structure, string)
     * @return string
     */
    public function generate(): string
    {
        $res = '';
        foreach ($this->source as $sourceItem) {
            try {
                $res .= $this->strategy->generate($sourceItem) . "\n\n";
            } catch (\Throwable $e) {
            }
        }
        return $res;
    }
}

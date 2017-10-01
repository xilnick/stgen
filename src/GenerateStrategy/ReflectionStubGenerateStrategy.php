<?php

declare(strict_types=1);

namespace Stgen\GenerateStrategy;

use Stgen\Source\Item\ISourceItem;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Reflection\ClassReflection;

class ReflectionStubGenerateStrategy implements IGenerateStrategy
{
    public function generate(ISourceItem $source): string
    {
        $reflection = new ClassReflection($source->getValue());
        $generator = ClassGenerator::fromReflection($reflection);
        return $generator->generate();
    }
}

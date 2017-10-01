<?php

declare(strict_types=1);

namespace Stgen\Cli;

use Stgen\CodeGenerator;
use Stgen\GenerateStrategy\ReflectionStubGenerateStrategy;
use Stgen\Source\PSR4ClassSource;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateStubCommand extends Command
{
    /**
     * @inheritDoc
     */
    public function __construct()
    {
        parent::__construct('generate:stub');
    }

    /**
     * @inheritDoc
     */
    protected function configure()
    {
        $this
            ->addUsage('stgen < source path > < destination path > [ --namespace|-ns < namespace prefix >]')
            ->addArgument(
                'sourcePath',
                InputArgument::REQUIRED,
                'Path where files are located must be specified as a first argument.'
            )
            ->addArgument(
                'savePath',
                InputArgument::REQUIRED,
                'Path where dump will be saved must be specified as a second argument.'
            )
            ->addOption(
                'namespace',
                null,
                InputOption::VALUE_OPTIONAL,
                'Base namespace which will be used for prefixing found namespaces.',
                null
            )
            ->addOption(
                'autoloader',
                null,
                InputOption::VALUE_OPTIONAL,
                'Autoloader file which will be included for loading source files.'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $src = realpath($input->getArgument('sourcePath'));
        $savePath = $input->getArgument('savePath');

        $namespacePref = $input->getOption('namespace');
        $autoloader = realpath($input->getOption('autoloader'));

        if ($autoloader) {
            require_once $autoloader;
        }

        $generator = new CodeGenerator(
            new ReflectionStubGenerateStrategy(),
            new PSR4ClassSource($src, $namespacePref)
        );

        $generated = $generator->generate();
        $output->writeln($generated);
        file_put_contents($savePath, "<?php\n\n" . $generated);
    }
}

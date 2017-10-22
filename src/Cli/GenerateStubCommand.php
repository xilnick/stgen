<?php

declare(strict_types=1);

namespace Stgen\Cli;

use Stgen\CodeGenerator;
use Stgen\Writer\SingleFileWriter;
use Stgen\Generator\ReflectionStubGenerateStrategy;
use Stgen\Source\BlacklistSourceDecorator;
use Stgen\Source\PSR4ClassSource;
use Stgen\Source\SingleFileClassSource;
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
                'Colon-separated list of autoloader files which will be included for loading source files.'
            )
            ->addOption(
                'blacklist',
                null,
                InputOption::VALUE_OPTIONAL,
                'Colon-separated list of path which must be excluded from generated list.'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->processAutoloader($input->getOption('autoloader'));

        $savePath = $input->getArgument('savePath');
        $sourcePath = realpath($input->getArgument('sourcePath'));
        $namespacePref = $input->getOption('namespace');

        if (is_dir($sourcePath)) {
            $source = new PSR4ClassSource($sourcePath, $namespacePref);
        } else {
            $source = new SingleFileClassSource($sourcePath, $namespacePref);
        }

        $writer = new SingleFileWriter($sourcePath);

        $blacklist = $this->prepareBlackList($input->getOption('blacklist'));

        if ($blacklist) {
            $source = new BlacklistSourceDecorator($source, $blacklist);
        }

        $generator = new CodeGenerator(
            new ReflectionStubGenerateStrategy(),
            $source,
            $writer
        );

        $generator->generate();
    }

    /**
     * @param $list
     * @return array
     */
    public function prepareBlackList($list)
    {
        $list = explode(':', (string)$list);
        array_walk($list, function (&$v) {
            return realpath($v);
        });
        $list = array_filter($list, function ($v) {
            return $v;
        });
        return $list;
    }

    /**
     * @param string $autoloaders
     */
    public function processAutoloader($autoloaders)
    {
        $autoloaders = explode(':', $autoloaders);
        foreach ($autoloaders as $autoloader) {
            $autoloader = realpath($autoloader);
            if ($autoloader) {
                $this->requireIsolated($autoloader);
            }
        }
    }

    /**
     * Scope isolated require.
     * @param string $path
     */
    public function requireIsolated(string $path)
    {
        require $path;
    }
}

<?php

declare(strict_types=1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

$cli = new \Symfony\Component\Console\Application('Stgen', '0.1');

$cli->add(new \Symfony\Component\Console\Command\HelpCommand());
$cli->add(new \Symfony\Component\Console\Command\ListCommand());
$cli->add(new \Stgen\Cli\GenerateStubCommand());

$cli->run();

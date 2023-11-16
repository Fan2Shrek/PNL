<?php

namespace Pnl\App\Command;

use Pnl\App\AbstractCommand;
use Pnl\Application;
use \Pnl\Console\Input\InputInterface;
use \Pnl\Console\Output\OutputInterface;
use Pnl\Service\ClassAdapter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class HelpCommand extends AbstractCommand
{
    protected const NAME = 'help';

    public function __construct(private ClassAdapter $application)
    {
    }

    public function getDescription(): string
    {
        return 'Show this help';
    }

    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        dd($this->application);
    }
}

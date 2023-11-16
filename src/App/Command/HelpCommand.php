<?php

namespace Pnl\App\Command;

use Pnl\Application;
use Pnl\App\AbstractCommand;
use Pnl\App\CommandInterface;
use Pnl\Service\ClassAdapter;
use \Pnl\Console\Input\InputInterface;
use \Pnl\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class HelpCommand extends AbstractCommand
{
    protected const NAME = 'help';

    /**
     * @var CommandInterface[]
     */
    private array $commandList = [];

    public function __construct(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds('command') as $key => $command) {
            if ($key !== self::class) {
                $this->commandList[] = $container->get($key);
            }
        }
    }

    public function getDescription(): string
    {
        return 'Show this help';
    }

    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        dd($this->commandList);
    }
}

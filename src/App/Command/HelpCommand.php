<?php

namespace Pnl\App\Command;

use Pnl\Application;
use Pnl\App\AbstractCommand;
use Pnl\App\CommandInterface;
use Pnl\Service\ClassAdapter;
use \Pnl\Console\Input\InputInterface;
use Pnl\Console\Output\ANSI\TextColors;
use Pnl\Console\Output\ANSI\Style as ANSIStyle;
use \Pnl\Console\Output\OutputInterface;
use Pnl\Console\Output\Style\CustomStyle;
use Pnl\Console\Output\ANSI\BackgroundColor;
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
        $this->getAllCommand($container);
    }

    private function getAllCommand(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('command') as $key => $command) {
            if ($key !== self::class) {
                $this->commandList[] = $container->get($key);
            }
        }

        $this->commandList[] = $this;
    }

    public function getDescription(): string
    {
        return 'Show this help';
    }

    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        $style = new CustomStyle($output);

        $style->createStyle('name')
        ->setColor(TextColors::WHITE)
            ->setStyle(ANSIStyle::ITALIC);

        $style->createStyle('description')
        ->setColor(TextColors::GREEN)
            ->setStyle(ANSIStyle::BOLD);

        $style->write('Available commands :');
        $style->newLine();

        foreach ($this->commandList as $command) {
            $style->newLine();
            $style->writeWithStyle(
                sprintf('%s :', $command->getName()),
                'name'
            );

            $style->newLine();

            $style->writeWithStyle(
                sprintf('%s', $command->getDescription()),
                'description'
            );
        }
    }
}

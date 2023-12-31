<?php

namespace Pnl\App\Command;

use Pnl\Application;
use Pnl\App\AbstractCommand;
use Pnl\App\CommandInterface;
use Pnl\Service\ClassAdapter;
use Pnl\Console\Input\ArgumentBag;
use Pnl\Console\Input\ArgumentType;
use \Pnl\Console\Input\InputInterface;
use Pnl\Console\Output\ANSI\TextColors;
use \Pnl\Console\Output\OutputInterface;
use Pnl\Console\Output\Style\CustomStyle;
use Pnl\Console\Output\ANSI\BackgroundColor;
use Pnl\App\Exception\CommandNotFoundException;
use Pnl\Console\Output\ANSI\Style as ANSIStyle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;

final class HelpCommand extends AbstractCommand
{
    protected const NAME = 'help';

    /**
     * @var CommandInterface[]
     */
    private array $commandList = [];

    private ?CustomStyle $style = null;

    public function __construct(ContainerBuilder $container)
    {
        $this->getAllCommand($container);
    }

    public function getDescription(): string
    {
        return 'Show this help';
    }

    public static function getArguments(): ArgumentBag
    {
        return (new ArgumentBag())->add('command', false, 'The command name', ArgumentType::STRING, nameless: true);
    }

    private function getAllCommand(ContainerBuilder $container): void
    {
        foreach ($container->findTaggedServiceIds('command') as $key => $command) {
            if ($key !== self::class) {
                $command = $container->get($key);
                $this->commandList[$command->getName()] = $command;
            }
        }

        $this->commandList[self::NAME] = $this;
    }

    private function setStyle(OutputInterface $output): void
    {
        $style = new CustomStyle($output);

        $style->createStyle('name')
        ->setColor(TextColors::WHITE)
            ->setStyle(ANSIStyle::ITALIC);

        $style->createStyle('description')
        ->setColor(TextColors::GREEN)
            ->setStyle(ANSIStyle::BOLD);

        $this->style = $style;
    }


    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        $this->setStyle($output);

        if ($input->haveNameless()) {
            $this->getDetail($input->getNameless());

            return;
        }

        $this->showAllCommand();
    }

    private function getDetail(string $commandName): void
    {
        if (!isset($this->commandList[$commandName])) {
            throw new CommandNotFoundException(sprintf('Command %s does not exist', $commandName));
        }

        $command = $this->commandList[$commandName];

        $this->printCommand($command);

        /**@todo Arguements */

        return;
    }

    private function showAllCommand(): void
    {
        $this->style->write('Available commands :');
        $this->style->newLine();

        foreach ($this->commandList as $command) {
            $this->style->newLine();
            $this->printCommand($command);
        }
    }

    private function printCommand(CommandInterface $command): void
    {
        $width = (int)exec('tput cols');

        $this->style->writeWithStyle(
            sprintf('%s :', ucfirst($command->getName())),
            'name'
        );

        $spaces = $width - strlen($command->getName()) - strlen($command->getDescription()) - 3;

        if ($spaces < 0) {
            $spaces = 0;
            $this->style->newLine();
        }

        $this->style->writeWithStyle(
            sprintf(
                '%s%s',
                str_repeat(' ', $spaces),
                $command->getDescription()
            ),
            'description'
        );
        $this->style->newLine();
    }
}

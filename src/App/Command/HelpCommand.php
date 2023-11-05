<?php

namespace Pnl\App\Command;

use Pnl\App\AbstractCommand;
use Pnl\Console\Output\Style\Style;
use Pnl\Console\Input\InputInterface;
use Pnl\Console\Output\ANSI\TextColors;
use Pnl\Console\Output\OutputInterface;
use Pnl\Console\Output\ANSI\BackgroundColor;
use Pnl\Console\Output\ANSI\Style as ANSIStyle;

class HelpCommand extends AbstractCommand
{
    protected const NAME = 'help';

    public function getDescription(): string
    {
        return 'Help command';
    }

    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        $style = new Style($output);

        $style->setColor(TextColors::BLACK)
            ->setBackground(BackgroundColor::WHITE)
            ->setStyle(ANSIStyle::ITALIC)
            ->start();

        $style->write('Welcome to PNL Framework !');
    }
}

<?php

namespace Pnl\App\Command;

use Pnl\App\AbstractCommand;
use Pnl\Console\Output\Style\Style;
use Pnl\Console\Input\InputInterface;
use Pnl\Console\Output\ANSI\TextColors;
use Pnl\Console\Output\OutputInterface;
use Pnl\Console\Output\ANSI\BackgroundColor;
use Pnl\Console\Output\ANSI\Style as ANSIStyle;
use Pnl\Console\Output\Style\CustomeStyle;

class HelpCommand extends AbstractCommand
{
    protected const NAME = 'help';

    public function getDescription(): string
    {
        return 'Help command';
    }

    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        $style = new CustomeStyle($output);

        $subtitleStyle = new Style($output);
        $subtitleStyle->setColor(TextColors::GREEN)
            ->setBackground(BackgroundColor::BLACK)
            ->setStyle(ANSIStyle::ITALIC);

        $style->addStyle('subtitle', $subtitleStyle);

        $basicStyle = new Style($output);
        $basicStyle->setColor(TextColors::BLACK)
            ->setBackground(BackgroundColor::WHITE);

        $style->addStyle('basic', $basicStyle);

        $style->writeWithStyle('Welcome to PNL Framework !', 'basic');
        $style->newLine();
        $style->writeWithStyle('Made By Fan2Shrek :)', 'subtitle');
    }
}

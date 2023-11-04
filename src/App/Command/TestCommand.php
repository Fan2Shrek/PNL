<?php

namespace Pnl\App\Command;

use Pnl\App\AbstractCommand;
use Pnl\Console\Input\ArgumentBag;
use Pnl\Console\Input\ArgumentType;
use Pnl\Console\Input\InputInterface;

class TestCommand extends AbstractCommand
{
    protected const NAME = 'test';

    public static function getArguments(): ArgumentBag
    {
        return (new ArgumentBag())
            ->add('john', TRUE, 'Test argument', ArgumentType::STRING)
            ->add('joe', FALSE, 'Test argument 2', ArgumentType::BOOLEAN, TRUE);
    }

    public function getDescription(): string
    {
        return 'Test command';
    }

    public function __invoke(InputInterface $input): void
    {
        echo sprintf('%s de ouf', $input->john), PHP_EOL;
    }
}

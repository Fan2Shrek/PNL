<?php

namespace Pnl\App;

use Pnl\Console\Input\ArgumentBag;
use Pnl\Console\Input\InputInterface;

interface CommandInterface
{
    public static function getArguments(): ArgumentBag;

    public function __invoke(InputInterface $input): void;

    public function getName(): string;

    public function getDescription(): string;
}

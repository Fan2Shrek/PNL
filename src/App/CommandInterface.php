<?php

namespace Pnl\App;

use Pnl\Console\Input\ArgumentBag;
use Pnl\Console\Input\ArgumentDefinition;

interface CommandInterface
{
    public static function getArguments(): ArgumentBag;

    public function __invoke(): void;

    public function getName(): string;

    public function getDescription(): string;
}

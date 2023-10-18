<?php

namespace Pnl\App;

use Pnl\Console\Input\ArgumentBag;

interface CommandInterface
{
    public static function getArguments(): ArgumentBag;

    public function __invoke(): void;

    public function getName(): string;

    public function getDescription(): string;
}

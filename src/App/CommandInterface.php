<?php

namespace Pnl\App;

interface CommandInterface
{
    public function __invoke(): void;

    public function getName(): string;

    public function getDescription(): string;
}

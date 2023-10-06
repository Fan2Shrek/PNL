<?php

namespace Pnl\Runtime\Runner;

use Pnl\Application;

class AppRunner implements RunnerInterface
{
    public function __construct(private Application $app)
    {
    }

    public function run(): void
    {
        $this->app->run();
    }
}

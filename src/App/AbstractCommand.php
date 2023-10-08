<?php

namespace Pnl\App;

abstract class AbstractCommand implements CommandInterface
{
    private const NAME = '';

    public function getName(): string
    {
        if (empty(static::NAME)) {
            dd(static::NAME);
            throw new \Exception(sprintf('Command %s does not have a name :(', static::class));
        }

        return static::NAME;
    }
}

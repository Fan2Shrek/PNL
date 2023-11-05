<?php

namespace Pnl\Console\Output\Style;

use Pnl\Console\Output\Style\Style;

class CustomeStyle extends AbstractStyle
{
    /**
     * @var Style[]
     */
    private array $styles = [];

    public function addStyle(string $name, Style $value): static
    {
        $this->styles[$name] = $value;

        return $this;
    }

    /**
     * @return Style[]
     */
    public function getStyles(): array
    {
        return $this->styles;
    }
}

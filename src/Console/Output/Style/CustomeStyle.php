<?php

namespace Pnl\Console\Output\Style;

use Pnl\Console\Output\Style\Style;

class CustomeStyle extends AbstractStyle
{
    /**
     * @var Style[]
     */
    private array $styles = [];

    private ?Style $currentStyle = null;

    public function has(string $name): bool
    {
        return isset($this->styles[$name]);
    }

    public function get(string $name): ?Style
    {
        if (!$this->has($name)) {
            return null;
        }

        return $this->styles[$name];
    }

    public function addStyle(string $name, Style $style): static
    {
        if ($this->has($name)) {
            throw new \Exception(sprintf('Style %s already exists', $name));
        }

        $this->styles[$name] = $style;

        return $this;
    }

    public function newLine(): void
    {
        $this->output->writeln('');
    }

    public function writeWithStyle(string $message, string $style = null): void
    {
        if (null === $style) {
            $this->output->write($message);

            return;
        }

        if (!$this->has($style)) {
            throw new \Exception(sprintf('Style %s does not exists', $style));
        }

        if (null === $this->currentStyle || null !== $style) {
            $this->currentStyle = $this->get($style);
        }

        $this->currentStyle->write($message);
    }
}

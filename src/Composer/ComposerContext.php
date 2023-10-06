<?php

namespace Pnl\Composer;

readonly class ComposerContext
{
    private string $name;

    private string $type;

    private array $autoload;

    private array $authors;

    private array $require;

    private array $require_dev;

    public static function createFromJson(string $path): self
    {
        $json = json_decode(file_get_contents($path), true);

        $self = new self();

        $self->name = $json['name'];
        $self->type = $json['type'];
        $self->autoload = $json['autoload'];
        $self->authors = $json['authors'];
        $self->require = $json['require'];
        $self->require_dev = $json['require-dev'];

        return $self;
    }
}

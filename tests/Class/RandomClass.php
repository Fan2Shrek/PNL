<?php

namespace App\Tests\Class;

class RandomClass
{
    private readonly string $banane;

    private readonly string $type;

    private readonly int $prix;

    public function test(): string
    {
        return $this->banane . ' ' . $this->type . ' ' . $this->prix;
    }
}

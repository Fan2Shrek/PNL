<?php

namespace Pnl\File;

interface FileInterface
{
    public function setContent(string $content): void;

    public function getContent(): string;

    public function getPath(): string;

    public function getFilename(): string;

    public function getExtension(): string;

    public function getStream(): \SplFileObject;
}

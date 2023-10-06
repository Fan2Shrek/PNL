<?php

namespace Pnl\File;

class File implements FileInterface
{
    public function __construct(
        private string $path,
        private string $extension,
        private string $filename,
        private string $content = '',
    ) {
    }

    public function setContent(string $content): void
    {
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getFilename(): string
    {
        return $this->filename;
    }

    public function getExtension(): string
    {
        return $this->extension;
    }

    public function getStream(): \SplFileObject
    {
        return new \SplFileObject($this->path);
    }
}

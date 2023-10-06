<?php

namespace Pnl\File;

class FileExporter
{
    public function export(string $path, string $content): void
    {
        if (file_exists($path)) {
            throw new \Exception(sprintf('File %s already exists', $path));
        }

        try {
            $this->createDirectoryIfNotExists($path);
            $this->createFile($path);
        } catch (\Exception $e) {
            throw new \Exception(sprintf('Error while exporting file %s', $path));
        }

        file_put_contents($path, $content);
    }

    private function createDirectoryIfNotExists(string $path): void
    {
        $directory = dirname($path);

        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    private function createFile(string $path): void
    {
        if (!touch($path)) {
            throw new \Exception(sprintf('Error while creating file %s', $path));
        }
    }
}

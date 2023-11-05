<?php

namespace Pnl\File;

class FileInstanciator implements FileInstanciatorInterface
{
    public function instanciate(string $path): FileInterface
    {
        if (\file_exists($path)) {
            throw new \Exception(\sprintf('Files %s already exist', $path));
        }

        return new File(...$this->parsePath($path));
    }

    /**
     * @return array{
     *    path: string,
     *    filename: string,
     *    extension: string
     * }
     */
    private function parsePath(string $path): array
    {
        return [
            "path" => \pathinfo($path, PATHINFO_DIRNAME),
            "filename" => \pathinfo($path, PATHINFO_FILENAME),
            "extension" => \pathinfo($path, PATHINFO_EXTENSION),
        ];
    }
}

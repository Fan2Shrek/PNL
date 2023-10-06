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

    private function parsePath(string $paht): array
    {
        return [
            "path" => \pathinfo($paht, PATHINFO_DIRNAME),
            "filename" => \pathinfo($paht, PATHINFO_FILENAME),
            "extension" => \pathinfo($paht, PATHINFO_EXTENSION),
        ];
    }
}

<?php

namespace Pnl\File;

interface FileInstanciatorInterface
{
    public function instanciate(string $path): FileInterface;
}

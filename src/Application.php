<?php

namespace Pnl;

use Pnl\Service\ClassAdapter;
use Composer\Autoload\ClassLoader;
use Pnl\Composer\ComposerContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

class Application
{
    private ClassAdapter $classAdapter;

    private ContainerInterface $container;

    private ?ComposerContext $composerContext = null;

    private bool $isBooted = false;

    public function __construct(private ClassLoader $classLoader, private array $context = [])
    {
        $this->classAdapter = new ClassAdapter();
    }

    private function boot(): void
    {
        if ($this->isBooted) {
            return;
        }

        if (null === $this->composerContext) {
            $this->loadComposerContext();
        }

        $this->isBooted = true;
    }

    private function loadComposerContext(): true
    {
        if (!file_exists('composer.json')) {
            throw new \Exception('composer.json not found');
        }

        $this->composerContext = ComposerContext::createFromJson('composer.json');

        return true;
    }

    public function adaptWorkSpace(): void
    {
        $this->classAdapter;
    }

    public function run(): void
    {
        $this->boot();

        return;
    }
}

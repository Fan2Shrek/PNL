<?php

namespace Pnl;

use Pnl\Service\ClassAdapter;
use Pnl\Composer\ComposerContext;
use Composer\Autoload\ClassLoader;
use Pnl\App\CommandInterface;
use Pnl\App\DependencyInjection\AddCommandPass;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Application
{
    private ClassAdapter $classAdapter;

    private ?Container $container = null;

    private ?ComposerContext $composerContext = null;

    private array $context = [];

    private bool $isBooted = false;

    private array $commandList = [];

    public function __construct(private ClassLoader $classLoader, array $context = [])
    {
        $this->classAdapter = new ClassAdapter();
        $this->context = $context;
    }

    public function run(array $args = []): void
    {
        $this->boot();

        if (empty($this->commandList)) {
            throw new \Exception('No commands found');
        }

        if (empty($args)) {
            return;
        }

        if ($this->hasCommandName($args[0])) {
            $command = $this->getCommand($args[0]);
            array_shift($args);
            $command($args);
        }

        return;
    }

    private function boot(): void
    {
        if ($this->isBooted) {
            return;
        }

        if (null === $this->composerContext) {
            $this->loadComposerContext();
        }

        if (null === $this->container) {
            $this->initializeContainer();
        }

        $this->isBooted = true;
    }

    private function initializeContainer(): void
    {
        $builder = new ContainerBuilder();

        $builder->addObjectResource($this);

        $loader = new YamlFileLoader($builder, new FileLocator(__DIR__ . '/../config'));
        $loader->load('services.yaml');

        //Add commands to compile
        $builder->addCompilerPass(new AddCommandPass($this));

        $builder->compile();

        $this->container = $builder;
    }

    private function loadComposerContext(): true
    {
        if (!file_exists('composer.json')) {
            throw new \Exception('composer.json not found');
        }

        $this->composerContext = ComposerContext::createFromJson('composer.json');

        return true;
    }

    private function hasCommandName(string $commandName): bool
    {
        return array_key_exists($commandName, $this->commandList);
    }

    private function getCommand(string $commandName): CommandInterface
    {
        return $this->commandList[$commandName];
    }


    public function addCommand(CommandInterface $command): void
    {
        if (!$this->hasCommand($command)) {
            $this->commandList[$command->getName()] = $command;
        }
    }

    public function hasCommand(CommandInterface $command): bool
    {
        return in_array($command->getName(), $this->commandList);
    }

    public function adaptWorkSpace(): void
    {
        $this->classAdapter;
    }
}

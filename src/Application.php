<?php

namespace Pnl;

use Pnl\Console\Input\Input;
use Pnl\Service\ClassAdapter;
use Pnl\Composer\ComposerContext;
use Composer\Autoload\ClassLoader;
use Pnl\App\CommandInterface;
use Pnl\App\DependencyInjection\AddCommandPass;
use Pnl\Console\Input\InputInterface;
use Pnl\Console\InputResolver;
use Pnl\Console\InputResolverInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Application
{
    private Container $container;

    private ComposerContext $composerContext;

    private array $context = [];

    private bool $isBooted = false;

    private array $commandList = [];

    public function __construct(private ClassLoader $classLoader, array $context = [])
    {
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
            $name = $args[0];
            array_shift($args);
            $this->executeCommand($this->getCommand($name), new Input($args));
        }

        return;
    }

    private function boot(): void
    {
        if ($this->isBooted) {
            return;
        }

        if (!isset($this->composerContext)) {
            $this->loadComposerContext();
        }

        if (!isset($this->container)) {
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

    public function executeCommand(CommandInterface $command, InputInterface $input): void
    {
        $args = $this->getInputResolver()->resolve($command, $input);

        $command($args);
    }

    public function getInputResolver(): InputResolverInterface
    {
        return $this->container->get(InputResolver::class);
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
}

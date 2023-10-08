<?php

namespace Pnl\App\DependencyInjection;

use Pnl\Application;
use Pnl\App\CommandInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class AddCommandPass implements CompilerPassInterface
{
    public function __construct(private Application $application)
    {
    }

    public function process(ContainerBuilder $container)
    {
        foreach ($container->getServiceIds() as $service) {
            try {
                if ($container->has($service)) {
                    $serviceDefinition = $container->getDefinition($service);
                    $class = $serviceDefinition->getClass();

                    if ($class && class_exists($class)) {
                        $reflection = new \ReflectionClass($class);

                        if ($reflection->implementsInterface(CommandInterface::class)) {
                            $serviceDefinition->addTag('command');

                            $this->application->addCommand($container->get($service));
                        }
                    }
                }
            } catch (ServiceNotFoundException $e) {
                continue;
            }
        }
    }
}

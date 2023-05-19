<?php

declare(strict_types=1);

namespace Madikon\GrumphpTypoScriptLint\Extension;

use GrumPHP\Extension\ExtensionInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Madikon\GrumphpTypoScriptLint\Task\TypoScriptLint;

/**
 * Class Loader
 */
class Loader implements ExtensionInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function load(ContainerBuilder $container): void
    {
        $container->register('task.typoscriptlint', TypoScriptLint::class)
            ->addArgument(new Reference('process_builder'))
            ->addArgument(new Reference('formatter.raw_process'))
            ->addTag('grumphp.task', ['task' => 'typoscriptlint']);
    }
}

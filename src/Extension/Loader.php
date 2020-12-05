<?php

declare(strict_types=1);

namespace TSystems\GrumphpTypoScriptLint\Extension;

use GrumPHP\Extension\ExtensionInterface;
use TSystems\GrumphpTypoScriptLint\Task\TypoScriptLint;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class Loader
 * @package TSystems\GrumphpTypoScriptLint\Extension
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

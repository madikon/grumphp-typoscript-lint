<?php

declare(strict_types=1);

namespace Madikon\GrumphpTypoScriptLint\Task;

use GrumPHP\Runner\TaskResult;
use GrumPHP\Runner\TaskResultInterface;
use GrumPHP\Task\AbstractExternalTask;
use GrumPHP\Task\Context\ContextInterface;
use GrumPHP\Task\Context\GitPreCommitContext;
use GrumPHP\Task\Context\RunContext;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TypoScriptLint
 */
class TypoScriptLint extends AbstractExternalTask
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'typoscriptlint';
    }

    /**
     * @return OptionsResolver
     */
    public static function getConfigurableOptions(): OptionsResolver
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults(
            [
                'triggered_by' => ['typoscript', 'tsconfig'],
                'config' => dirname(__DIR__, 2) . '/typoscript-lint.yaml',
                'format' => 'compact',
                'output' => '-',
                'ansi' => true,
                'fail-on-warnings' => true,
                'paths' => [],
                'exclude' => []
            ]
        );
        $resolver->addAllowedTypes('triggered_by', ['array']);
        $resolver->addAllowedTypes('config', ['string']);
        $resolver->addAllowedTypes('format', ['null', 'string']);
        $resolver->addAllowedTypes('output', ['null', 'string']);
        $resolver->addAllowedTypes('fail-on-warnings', ['null', 'bool']);
        $resolver->addAllowedTypes('ansi', ['null', 'bool']);
        $resolver->addAllowedTypes('paths', ['null', 'array']);
        $resolver->addAllowedTypes('exclude', ['null', 'array']);
        return $resolver;
    }

    /**
     * @param ContextInterface $context
     * @return bool
     */
    public function canRunInContext(ContextInterface $context): bool
    {
        return $context instanceof GitPreCommitContext || $context instanceof RunContext;
    }

    /**
     * @param ContextInterface $context
     * @return TaskResultInterface
     */
    public function run(ContextInterface $context): TaskResultInterface
    {
        $config = $this->getConfig()->getOptions();

        $files = $context->getFiles()
            ->paths($config['paths'] ?? [])
            ->notPaths($config['exclude'] ?? [])
            ->extensions($config['triggered_by']);

        if (0 === count($files)) {
            return TaskResult::createSkipped($this, $context);
        }

        $arguments = $this->processBuilder->createArgumentsForCommand('typoscript-lint');
        $arguments->addOptionalArgument('--config=%s', $config['config']);
        $arguments->addOptionalArgument('--format=%s', $config['format']);
        $arguments->addOptionalArgument('--output=%s', $config['output']);
        $arguments->addOptionalArgument('--fail-on-warnings', $config['fail-on-warnings']);
        $arguments->addOptionalArgument('--ansi', $config['ansi']);
        $arguments->addFiles($files);

        $process = $this->processBuilder->buildProcess($arguments);
        $process->run();

        if (!$process->isSuccessful()) {
            return TaskResult::createFailed($this, $context, $this->formatter->format($process));
        }

        return TaskResult::createPassed($this, $context);
    }
}

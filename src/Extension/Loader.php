<?php

declare(strict_types=1);

namespace Madikon\GrumphpTypoScriptLint\Extension;

use GrumPHP\Extension\ExtensionInterface;

/**
 * Class Loader
 */
class Loader implements ExtensionInterface
{
    public function imports(): iterable
    {
        yield dirname(__DIR__) . '/../typoscript-lint-extension.yaml';
    }
}

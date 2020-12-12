[![Build Status](https://travis-ci.com/cap47/grumphp-typoscript-lint.svg?branch=master)](https://travis-ci.com/cap47/grumphp-typoscript-lint)
# Grumphp Typoscript Lint

A TypoScript lint task for [GrumPHP](https://github.com/phpro/grumphp).
Based on the TypoScript Linter of Martin Helmich [martin-helmich/typo3-typoscript-lint](https://github.com/martin-helmich/typo3-typoscript-lint)

## Installation

Install composer package

```bash
composer require --dev tsystems/grumphp-typoscript-lint
  ```

Add the extension loader to your `grumphp.yml`

```yaml
grumphp:
  extensions:
    - TSystems\GrumphpTypoScriptLint\Extension\Loader
```

## Usage

Default configuration for grumphp

```yaml
grumphp:
  tasks:
    typoscriptlint:
      config: "path/to/your/typoscriptlint-config.yaml"
      paths:
        - "path/to/include"
      exclude:
        - "path/or/file/to/exclude"
      triggered_by:
        - typoscript
        - tsconfig
      format: "compact"
      fail-on-warnings: true
      output: "-"
```

Results in the folowing command line call

```bash
vendor/bin/typoscript-lint --config=path/to/your/typoscriptlint-config.yaml --format=compact --output=- --fail-on-warnings file1.typoscript file2.typoscript
```
## Linter Configuration

For more detailed documentation and configuration please refer to  https://github.com/martin-helmich/typo3-typoscript-lint#configuration

# Repository Guidelines

## Project Structure & Module Organization
- `src/` — PHPStan rules and supporting utilities (`LaravelStrictRules\\...`).
- `tests/` — Rule tests (PHPStan RuleTestCase and fixtures). Keep test fixtures under `tests/Fixtures/` when needed.
- `composer.json` — Package metadata, autoload (`psr-4`), PHP >= 8.3, dev tools.
- `vendor/` — Composer dependencies (do not commit).

## Build, Test, and Development Commands
- `composer install` — Install dependencies.
- `composer dump-autoload -o` — Optimize autoloading during development.
- `vendor/bin/phpstan --version` — Sanity-check PHPStan availability.
- `vendor/bin/phpunit` — Run tests (add `phpunit/phpunit` in `require-dev` first).

Example local PHPStan run against a project:
- `vendor/bin/phpstan analyse -c phpstan.neon` — Use a NEON config that registers this package’s rules.

## Coding Style & Naming Conventions
- Follow PSR-12; 4-space indentation; `declare(strict_types=1);` at file top.
- Namespaces under `LaravelStrictRules\\` mirror folders, e.g. `src/Rules/Controller/ActionReturnTypeRule.php` → `LaravelStrictRules\\Rules\\Controller\\ActionReturnTypeRule`.
- Class names end with `Rule`; prefer `final` and constructor-injected deps.
- Keep rules small, single-purpose; extract helpers into `src/Support/`.

## Testing Guidelines
- Use `PHPStan\\Testing\\RuleTestCase<T>`; one test class per rule: `tests/Rules/ActionReturnTypeRuleTest.php`.
- Store code samples in `tests/Fixtures/...` and assert precise errors and line numbers.
- Cover happy/unhappy paths; aim for clear failure messages over breadth.
- Run with `vendor/bin/phpunit` and keep tests fast/deterministic.

## Commit & Pull Request Guidelines
- Use Conventional Commits: `feat:`, `fix:`, `docs:`, `test:`, `refactor:`, `chore:`.
- PRs must include: concise description, motivation, linked issues, before/after PHPStan output, and notes on BC impact. Add tests for new/changed rules.

## Security & Configuration Tips
- Minimum PHP: 8.3. No secrets required.
- Consumer configuration (example `phpstan.neon`):

```neon
includes: []
services:
    - LaravelStrictRules\Rules\Controller\ActionReturnTypeRule
parameters:
    paths: [app/]
    level: max
```

Keep changes focused and consistent with existing patterns; prefer incremental, well-tested additions.

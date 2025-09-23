<?php

declare(strict_types=1);

namespace LaravelStrictRules;

final class Configuration
{
    /**
     * @param array<string, bool> $ruleToggles
     */
    public function __construct(
        private readonly array $ruleToggles = [],
        private readonly bool $defaultRuleState = false,
    ) {
    }

    public function isRuleEnabled(string $ruleIdentifier): bool
    {
        return $this->ruleToggles[$ruleIdentifier] ?? $this->defaultRuleState;
    }
}

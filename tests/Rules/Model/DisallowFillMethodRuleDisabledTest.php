<?php

declare(strict_types=1);

namespace Tests\Rules\Model;

use LaravelStrictRules\Configuration;
use LaravelStrictRules\Rules\Model\DisallowFillMethodRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<DisallowFillMethodRule>
 */
final class DisallowFillMethodRuleDisabledTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new DisallowFillMethodRule(new Configuration());
    }

    public function testRuleSkipsWhenNotEnabled(): void
    {
        $this->analyse(
            [
                __DIR__ . '/../../Fixtures/Illuminate/Database/Eloquent/Model.php',
                __DIR__ . '/../../Fixtures/Support/FillHelper.php',
                __DIR__ . '/../../Fixtures/Models/User.php',
            ],
            [],
        );
    }
}

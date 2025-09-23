<?php

declare(strict_types=1);

namespace LaravelStrictRules\Rules\Model;

use LaravelStrictRules\Configuration;
use PhpParser\Node;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Identifier;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleError;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\ObjectType;

use function in_array;
use function sprintf;
use function strtolower;

/**
 * @implements Rule<MethodCall>
 */
final class DisallowFillMethodRule implements Rule
{
    private const string RULE_IDENTIFIER = 'laravelStrict.model.disallowFill';
    private const string DEFAULT_MODEL_CLASS = 'Illuminate\\Database\\Eloquent\\Model';

    /**
     * @param non-empty-string $modelClass
     */
    public function __construct(
        private readonly Configuration $configuration,
        private readonly string $modelClass = self::DEFAULT_MODEL_CLASS,
    ) {
    }

    public function getNodeType(): string
    {
        return MethodCall::class;
    }

    /**
     * @param MethodCall $node
     *
     * @return RuleError[]
     */
    public function processNode(Node $node, Scope $scope): array
    {
        if (!$this->configuration->isRuleEnabled(self::RULE_IDENTIFIER)) {
            return [];
        }

        if (!$node->name instanceof Identifier) {
            return [];
        }

        $originalMethodName = $node->name->toString();
        $methodName = strtolower($originalMethodName);

        if (!in_array($methodName, ['fill', 'forcefill'], true)) {
            return [];
        }

        $calledOnType = $scope->getType($node->var);

        if (!$calledOnType->isObject()->yes()) {
            return [];
        }

        $modelType = new ObjectType($this->modelClass);

        if (!$modelType->isSuperTypeOf($calledOnType)->yes()) {
            return [];
        }

        return [
            RuleErrorBuilder::message(
                sprintf(
                    'Calling %s() on Eloquent models is forbidden; assign model attributes explicitly instead.',
                    $originalMethodName,
                ),
            )->identifier(self::RULE_IDENTIFIER)->build(),
        ];
    }
}

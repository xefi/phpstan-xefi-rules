<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class NoBasicExceptionRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Expr\Throw_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->expr instanceof Node\Expr\New_) {
            $exceptionClass = $node->expr->class;
            if ($exceptionClass instanceof Node\Name && $exceptionClass->toString() === 'Exception') {
                return [
                    RuleErrorBuilder::message('Basic exceptions are not allowed. Please create a custom Exception instead.')
                        ->identifier('xefi.noBasicException')
                        ->build()
                ];
            }
        }

        return [];
    }
}

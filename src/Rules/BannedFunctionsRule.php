<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Name;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class BannedFunctionsRule implements Rule
{
    const BANNED_FUNCTIONS = ['dd'];

    public function getNodeType(): string
    {
        return Node\Expr\FuncCall::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        if (! $node->name instanceof Name) {
            return [];
        }

        $functionName = $node->name->toString();

        if (in_array($functionName, self::BANNED_FUNCTIONS, true)) {
            $errors[] = RuleErrorBuilder::message(
                sprintf('Method %s() is prohibited. Remove it or write in the logs using `Log::debug()` instead.', $functionName)
            )
            ->identifier('xefi.bannedFunctions')
            ->build();
        }

        return $errors;
    }
}

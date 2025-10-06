<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\TryCatch;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class NoTryCatchRule implements Rule
{
    public function getNodeType(): string
    {
        return TryCatch::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        return [
            RuleErrorBuilder::message("Try-catch's are forbidden. Please use Exceptions instead.")
                ->identifier('xefi.noTryCatch')
                ->build(),
        ];
    }
}

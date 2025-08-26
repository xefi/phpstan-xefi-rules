<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class MaxLinePerMethodRule implements Rule
{
    private const MAX_LINES = 40;
    private const RECOMMENDED_LINES = 20;


    public function getNodeType(): string
    {
        return Node\Stmt\ClassMethod::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $startLine = $node->getStartLine() + 1;
        $endLine = $node->getEndLine() - 1;
        $lineCount = $endLine - $startLine;

        if ($lineCount > self::MAX_LINES) {
            return [
                RuleErrorBuilder::message(
                    sprintf(
                        'The %s function has more than %d code lines. Please reduce it. The recommended method length is %d lines.',
                        $node->name->toString(),
                        self::MAX_LINES,
                        self::RECOMMENDED_LINES
                    )
                )
                ->line($node->getLine())
                ->identifier('xefi.maxLinePerMethod')
                ->build(),
            ];
        }

        return [];
    }
}
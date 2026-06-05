<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeTraverser;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Xefi\PHPStanRules\Visitors\CascadeDeleteVisitor;

class NoDeleteCascadeLaravelRule implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->extends?->toString() !== 'Illuminate\Database\Migrations\Migration') {
            return [];
        }

        $cascadeDeletes = [];

        foreach ($node->getMethods() as $method) {
            if (! in_array($method->name->toString(), ['up', 'down'], true)) {
                continue;
            }

            $traverser = new NodeTraverser();
            $traverser->addVisitor(new CascadeDeleteVisitor($cascadeDeletes));
            $traverser->traverse([$method]);
        }

        $errors = [];

        foreach ($cascadeDeletes as $cascadeDelete) {
            $errors[] = RuleErrorBuilder::message("Cascade delete detected in migration. Please do not delete cascade on the database. Handle it in the code instead.")
                ->line($cascadeDelete->getLine())
                ->identifier('xefi.noCascadeDeleteLaravel')
                ->build();
        }

        return $errors;
    }
}

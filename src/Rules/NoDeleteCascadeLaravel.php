<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\NodeTraverser;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use Xefi\PHPStanRules\Visitors\CascadeDeleteVisitor;

class NoDeleteCascadeLaravel implements Rule
{
    public function getNodeType(): string
    {
        return Class_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];
        $cascadeDeletes = [];

        foreach ($node->extends as $extend) {
            if ($extend === 'Illuminate\Database\Migrations\Migration') {
                foreach ($node->getMethods() as $method) {
                    if (in_array($method->name, ['up', 'down'])) {
                        $visitor = new CascadeDeleteVisitor($cascadeDeletes);
                        $traverser = new NodeTraverser;
                        $traverser->addVisitor($visitor);
                        $traverser->traverse([$method]);
                    }
                }
            }
        }

        foreach ($cascadeDeletes as $cascadeDelete) {
            $errors[] = RuleErrorBuilder::message("Cascade delete detected in migration. Please do not delete cascade on the database. Handle it in the code instead.")
                ->line($cascadeDelete->getLine())
                ->identifier('xefi.noCascadeDeleteLaravel')
                ->build();
        }

        return $errors;
    }
}

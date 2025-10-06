<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<Node>
 */
class NoLaravelObserverRule implements Rule
{
    protected static string $ruleIdentifier = 'xefi.noLaravelObserver';

    public function getNodeType(): string
    {
        return Node::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        $this->checkObserveMethod($errors, $node);
        $this->checkClassesAndNamespaces($errors, $node, $scope);
        $this->checkObservedByAttribute($errors, $node);

        return $errors;
    }

    protected function checkObserveMethod(array &$errors, Node $node) : void
    {
        if ($node instanceof Node\Expr\StaticCall && $node->name?->toString() === 'observe') {
            $errors[] = RuleErrorBuilder::message('Observers are forbidden because it can create technical debt. Please use Event & Listeners instead.')
                ->identifier(self::$ruleIdentifier)
                ->build();
        }
    }

    protected function checkClassesAndNamespaces(array &$errors, Node $node, Scope $scope) : void
    {
        if ($node instanceof Node\Stmt\Class_) {
            $className = $node->name->toString();
            $namespace = $scope->getNamespace();

            if (str_ends_with($className, 'Observer') || str_contains($namespace, 'Observers')) {
                $errors[] = RuleErrorBuilder::message('Observers are forbidden because it can create technical debt. Please use Event & Listeners instead.')
                    ->identifier(self::$ruleIdentifier)
                    ->build();
            }
        }
    }

    protected function checkObservedByAttribute(array &$errors, Node $node) : void
    {
        if ($node instanceof Node\Stmt\Class_) {
            foreach ($node->attrGroups as $attrGroup) {
                foreach ($attrGroup->attrs as $attr) {
                    if ($attr->name->getParts() !== null && in_array('ObservedBy', $attr->name->getParts(), true)) {
                        $errors[] = RuleErrorBuilder::message('Observers are forbidden because it can create technical debt. Please use Event & Listeners instead.')
                            ->identifier(self::$ruleIdentifier)
                            ->build();
                        break 2;
                    }
                }
            }
        }
    }

    // checker si les observers étendent l'observer Illuminate
}

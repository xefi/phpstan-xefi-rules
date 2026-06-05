<?php

namespace Xefi\PHPStanRules\Visitors;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;

class CascadeDeleteVisitor extends NodeVisitorAbstract
{
    private $cascadeDeletes;

    public function __construct(array &$cascadeDeletes)
    {
        $this->cascadeDeletes = &$cascadeDeletes;
    }

    public function leaveNode(Node $node)
    {
        if (! $node instanceof Node\Expr\MethodCall) {
            return null;
        }

        if (! $node->name instanceof Node\Identifier) {
            return null;
        }

        $methodName = $node->name->toString();

        if ($methodName === 'cascadeOnDelete') {
            $this->cascadeDeletes[] = $node;

            return null;
        }

        if ($methodName === 'onDelete') {
            foreach ($node->args as $arg) {
                if ($arg instanceof Node\Arg
                    && $arg->value instanceof Node\Scalar\String_
                    && strtolower($arg->value->value) === 'cascade'
                ) {
                    $this->cascadeDeletes[] = $node;

                    break;
                }
            }
        }

        return null;
    }
}

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
        if ($node instanceof Node\Expr\MethodCall) {
            if (isset($node->name) && $node->name->toString() === 'onDelete') {
                foreach ($node->args as $arg) {
                    if (isset($arg->value) && $arg->value->value === 'cascade') {
                        $this->cascadeDeletes[] = $node;
                    }
                }
            }
        }
    }
}

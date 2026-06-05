<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

class BooleanPropertyNamingRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Property::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if (! $this->isBooleanType($node->type)) {
            return [];
        }

        $errors = [];

        foreach ($node->props as $prop) {
            if (! str_starts_with($prop->name->name, 'is')) {
                $errors[] = RuleErrorBuilder::message('A boolean property should start with "is".')
                    ->identifier('xefi.booleanPropertyNaming')
                    ->build();
            }
        }

        return $errors;
    }

    private function isBooleanType(?Node $type): bool
    {
        if ($type instanceof Node\Identifier) {
            return strtolower($type->name) === 'bool';
        }

        if ($type instanceof Node\NullableType) {
            return $this->isBooleanType($type->type);
        }

        if ($type instanceof Node\UnionType || $type instanceof Node\IntersectionType) {
            foreach ($type->types as $innerType) {
                if ($this->isBooleanType($innerType)) {
                    return true;
                }
            }
        }

        return false;
    }
}

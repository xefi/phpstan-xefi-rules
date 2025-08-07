<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;
use PHPStan\Type\BooleanType;

class BooleanPropertyNamingRule implements Rule
{
    public function getNodeType(): string
    {
        return Node\Stmt\Property::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        foreach ($node->props as $prop) {
            $propertyName = $prop->name->name;
            $propertyType = $node->type->name;

            if ($propertyType === "bool" && substr($propertyName, 0, 2 ) !== "is") {
                $errors[] = RuleErrorBuilder::message('A boolean property should start with "is".')
                    ->line($node->getLine())
                    ->identifier('xefi.booleanPropertyNaming')
                    ->build();
            }
        }

        return $errors;
    }
}

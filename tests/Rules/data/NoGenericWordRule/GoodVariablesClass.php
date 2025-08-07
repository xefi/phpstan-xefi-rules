<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoGenericWordRule;

class GoodVariablesClass
{
    public function simpleFunction() {
        $subject = "A new rule";
        $description = "A rule for descriptive variable names";
    }
}
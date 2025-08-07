<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoGenericWordRule;

class BadVariablesClass
{
    public function simpleFunction() {
        $array = [1, 2, 3];
        $data = ["key" => "value"];
        $subject = "A rule for descriptive variable names";
        $result = true;
    }
}
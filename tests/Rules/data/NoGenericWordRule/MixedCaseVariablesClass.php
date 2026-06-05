<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoGenericWordRule;

class MixedCaseVariablesClass
{
    public function simpleFunction() {
        $Data = ["key" => "value"];
        $Result = true;
        $subject = "A descriptive name";
    }
}

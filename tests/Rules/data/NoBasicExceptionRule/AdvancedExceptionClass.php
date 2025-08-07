<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoBasicExceptionRule;

use Xefi\PHPStanRules\Tests\Rules\data\FooException;

class AdvancedExceptionClass
{
    public function doFoo() {
        throw new FooException("Test exception");
    }
}
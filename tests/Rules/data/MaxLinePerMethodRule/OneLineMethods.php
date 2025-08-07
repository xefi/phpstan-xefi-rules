<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\MaxLinePerMethodRule;

class OneLineMethods {
    public function oneLine(): void
    {
        echo 1;
    }

    public function anotherOneLine(): void
    {
        echo 1;
    }
}
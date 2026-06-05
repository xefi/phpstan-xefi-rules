<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoLaravelObserverRule;

class DynamicObserveCall
{
    public function boot(): void
    {
        $method = "observe";

        self::$method();
    }

    private static function observe(): void {}
}

<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoLaravelObserverRule;

class StaticObserveCall
{
    public function boot(): void {
        self::observe();
    }

    private static function observe(): void {}
}

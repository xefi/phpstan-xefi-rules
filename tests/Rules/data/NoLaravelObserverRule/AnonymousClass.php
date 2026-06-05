<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoLaravelObserverRule;

class AnonymousClassHolder
{
    public function make(): object
    {
        return new class {
            public function handle(): void {}
        };
    }
}

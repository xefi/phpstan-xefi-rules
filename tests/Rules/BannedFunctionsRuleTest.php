<?php declare(strict_types = 1);

namespace Xefi\PHPStanRules\Tests\Rules;

use Xefi\PHPStanRules\Rules\BannedFunctionsRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<BannedFunctionsRule>
 */
class BannedFunctionsRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new BannedFunctionsRule();
    }

    public function testRuleDetectsBannedFunctions(): void
    {
        $this->analyse([__DIR__ . '/data/BannedFunctionsRule/BannedFunctionsClass.php'], [
            [
                'Method dd() is prohibited. Remove it or write in the logs using `Log::debug()` instead.',
                3
            ],
        ]);
    }
}
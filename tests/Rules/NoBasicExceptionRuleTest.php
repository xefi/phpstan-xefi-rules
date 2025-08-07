<?php declare(strict_types = 1);

namespace Xefi\PHPStanRules\Tests\Rules;

use PHPStan\Testing\RuleTestCase;
use Xefi\PHPStanRules\Rules\NoBasicExceptionRule;

/**
 * @extends RuleTestCase<NoBasicExceptionRule>
 */
class NoBasicExceptionRuleTest extends RuleTestCase
{
    protected function getRule(): \PHPStan\Rules\Rule
    {
        return new NoBasicExceptionRule();
    }

    public function testRuleThrowsException(): void
    {
        $this->analyse([__DIR__ . '/data/NoBasicExceptionRule/BasicExceptionClass.php'], [
            ["Basic exceptions are not allowed. Please create a custom Exception instead.", 8]
        ]);
    }

    public function testRuleDoesNotThrowsException(): void
    {
        $this->analyse([__DIR__ . '/data/NoBasicExceptionRule/AdvancedExceptionClass.php'], []);
    }
}

<?php declare(strict_types = 1);

namespace Xefi\PHPStanRules\Tests\Rules;

use Xefi\PHPStanRules\Rules\NoTryCatchRule;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NoTryCatchRule>
 */
class NoTryCatchRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoTryCatchRule();
    }

    public function testRuleDumpAnException(): void
    {
        $this->analyse([__DIR__ . '/data/NoTryCatchRule/TryCatch.php'], [
            ["Try-catch's are forbidden. Please use Exceptions instead.", 9],
        ]);
    }

    public function testRuleDoesNotDumpException(): void
    {
        $this->analyse([__DIR__ . '/data/NoTryCatchRule/NoTryCatch.php'], []);
    }
}
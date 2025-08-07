<?php declare(strict_types = 1);

namespace Xefi\PHPStanRules\Tests\Rules;

use Xefi\PHPStanRules\Rules\NoGenericWordRule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NoGenericWordRule>
 */
class NoGenericWordRuleTest extends RuleTestCase
{
    protected function getRule(): \PHPStan\Rules\Rule
    {
        // getRule() method needs to return an instance of the tested rule
        return new NoGenericWordRule();
    }

    public function testRuleDumpAnException(): void
    {
        // first argument: path to the example file that contains some errors that should be reported by MyRule
        // second argument: an array of expected errors,
        // each error consists of the asserted error message, and the asserted error file line
        $this->analyse([__DIR__ . '/data/NoGenericWordRule/BadVariablesClass.php'], [
            [
                "Variable name \"array\" is too generic. Please use a more descriptive name.", // asserted error message
                8, // asserted error line
            ],
            [
                "Variable name \"data\" is too generic. Please use a more descriptive name.",
                9,
            ],
            [
                "Variable name \"result\" is too generic. Please use a more descriptive name.",
                11,
            ],
        ]);
    }

    public function testRuleDoesNotDumpException(): void
    {
        $this->analyse([__DIR__ . '/data/NoGenericWordRule/GoodVariablesClass.php'], []);
    }

    public function testRuleDoesNotHandleProperties(): void
    {
        $this->analyse([__DIR__ . '/data/NoGenericWordRule/PropertiesNotHandledClass.php'], []);
    }
}

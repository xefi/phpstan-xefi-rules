<?php declare(strict_types = 1);

namespace Xefi\PHPStanRules\Tests\Rules;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;
use Xefi\PHPStanRules\Rules\NoBagNameRule;

/**
 * @extends RuleTestCase<NoBagNameRule>
 */
class NoBagNameRuleTest extends RuleTestCase
{
    private const NAMESPACE = 'Xefi\PHPStanRules\Tests\Rules\data\NoBagNameRule';

    protected function getRule(): Rule
    {
        return new NoBagNameRule($this->createReflectionProvider());
    }

    public function testRuleDumpAnExceptionInABagNamespace(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/BagNamespace.php'], [
            [$this->inABagNamespace(self::NAMESPACE . '\Services\OrderTotals', 'Services'), 5],
        ]);
    }

    public function testRuleDumpAnExceptionInACatchAllNamespace(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/CatchAllNamespaceOnATrait.php'], [
            [$this->inABagNamespace(self::NAMESPACE . '\Support\ChannelLabels', 'Support'), 5],
        ]);
    }

    public function testRuleDumpAnExceptionOnABagSuffix(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/BagSuffix.php'], [
            [$this->endingInABagWord(self::NAMESPACE . '\OrderRepository', 'Repository'), 5],
        ]);
    }

    public function testRuleDumpAnExceptionOnABagSuffixOfATrait(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/BagSuffixOnATrait.php'], [
            [$this->endingInABagWord(self::NAMESPACE . '\OrderHelpers', 'Helpers'), 5],
        ]);
    }

    public function testRuleDumpAnExceptionOnTheSuffixOfAProjectParent(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/SuffixOfAProjectParent.php'], [
            [$this->endingInABagWord(self::NAMESPACE . '\InvoiceManager', 'Manager'), 5],
        ]);
    }

    public function testRuleDoesNotDumpExceptionOnTheSuffixOfAThirdPartyParent(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/SuffixOfAThirdPartyParent.php'], []);
    }

    public function testRuleDoesNotDumpExceptionOnTheSuffixOfAPhpInterface(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/SuffixOfAPhpInterface.php'], []);
    }

    public function testRuleDumpAnExceptionInABagNamespaceUnderAThirdPartyParent(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/BagNamespaceUnderAThirdPartyParent.php'], [
            [$this->inABagNamespace(self::NAMESPACE . '\Handlers\RefusingErrorHandler', 'Handlers'), 8],
        ]);
    }

    public function testRuleDoesNotDumpExceptionOnAContractNamedAfterItsAnswer(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/ContractNamedAfterItsAnswer.php'], []);
    }

    public function testRuleDoesNotDumpExceptionOnAServiceProvider(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/ServiceProvider.php'], []);
    }

    public function testRuleDoesNotDumpExceptionOnABagWordInsideAName(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/BagWordInsideAName.php'], []);
    }

    public function testRuleDoesNotDumpExceptionOnAnAnonymousClass(): void
    {
        $this->analyse([__DIR__ . '/data/NoBagNameRule/AnonymousClass.php'], []);
    }

    private function inABagNamespace(string $className, string $segment): string
    {
        return sprintf('%s sits in a "%s" namespace, a bag that attracts unrelated classes. Please move it to a namespace named after its domain.', $className, $segment);
    }

    private function endingInABagWord(string $className, string $suffix): string
    {
        return sprintf('%s ends in "%s", a bag name that attracts unrelated methods. Please name it after its single action, question or role.', $className, $suffix);
    }
}

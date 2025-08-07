<?php declare(strict_types = 1);

namespace Xefi\PHPStanRules\Tests\Rules;

use Xefi\PHPStanRules\Rules\NoDeleteCascadeLaravel;
use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

/**
 * @extends RuleTestCase<NoDeleteCascadeLaravel>
 */
class NoDeleteCascadeLaravelRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new NoDeleteCascadeLaravel();
    }

    public function testRuleDetectsCascade(): void
    {
        $this->analyse([__DIR__ . '/data/NoDeleteCascadeLaravelRule/BadMigration.php'], [
            ['Cascade delete detected in migration. Please do not delete cascade on the database. Handle it in the code instead.', 22],
            ['Cascade delete detected in migration. Please do not delete cascade on the database. Handle it in the code instead.', 30],
            ['Cascade delete detected in migration. Please do not delete cascade on the database. Handle it in the code instead.', 37]
        ]);
    }

    public function testRuleWithNoCascadeInFile(): void
    {
        $this->analyse([__DIR__ . '/data/NoDeleteCascadeLaravelRule/GoodMigration.php'], []);
    }

    public function testRuleWorksOnlyOnLaravelMigrations(): void
    {
        $this->analyse([__DIR__ . '/data/NoDeleteCascadeLaravelRule/NotALaravelMigration.php'], []);
    }
}
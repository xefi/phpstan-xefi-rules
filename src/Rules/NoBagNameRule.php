<?php

namespace Xefi\PHPStanRules\Rules;

use PhpParser\Node;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassLike;
use PhpParser\Node\Stmt\Enum_;
use PhpParser\Node\Stmt\Interface_;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PHPStan\Rules\RuleErrorBuilder;

/**
 * @implements Rule<ClassLike>
 */
class NoBagNameRule implements Rule
{
    protected static string $ruleIdentifier = 'xefi.noBagName';

    private const BAG_WORDS = [
        'Service', 'Services', 'Repository', 'Repositories', 'Manager', 'Managers', 'Helper', 'Helpers',
        'Handler', 'Handlers', 'Util', 'Utils', 'Utility', 'Utilities',
    ];

    private const CATCH_ALL_SEGMENTS = ['Support', 'Common', 'Misc'];

    public function __construct(private ReflectionProvider $reflectionProvider)
    {
    }

    public function getNodeType(): string
    {
        return ClassLike::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        if ($node->namespacedName === null) {
            return [];
        }

        $fullName = $node->namespacedName->toString();
        $namespaceSegments = explode('\\', $fullName);
        $shortName = array_pop($namespaceSegments);
        $errors = [];

        foreach (array_intersect($namespaceSegments, array_merge(self::BAG_WORDS, self::CATCH_ALL_SEGMENTS)) as $segment) {
            $errors[] = RuleErrorBuilder::message(sprintf('%s sits in a "%s" namespace, a bag that attracts unrelated classes. Please move it to a namespace named after its domain.', $fullName, $segment))
                ->identifier(self::$ruleIdentifier)
                ->build();
        }

        $suffix = $this->bagSuffixOf($shortName);

        if ($suffix !== null && !$this->takesTheSuffixOfAThirdPartyParent($node, $suffix)) {
            $errors[] = RuleErrorBuilder::message(sprintf('%s ends in "%s", a bag name that attracts unrelated methods. Please name it after its single action, question or role.', $fullName, $suffix))
                ->identifier(self::$ruleIdentifier)
                ->build();
        }

        return $errors;
    }

    private function bagSuffixOf(string $shortName): ?string
    {
        foreach (self::BAG_WORDS as $word) {
            if (str_ends_with($shortName, $word)) {
                return $word;
            }
        }

        return null;
    }

    private function takesTheSuffixOfAThirdPartyParent(ClassLike $node, string $suffix): bool
    {
        foreach ($this->parentsOf($node) as $parent) {
            $parentName = (string) preg_replace('/Interface$/', '', $parent->getLast());

            if (str_ends_with($parentName, $suffix) && $this->isThirdParty($parent->toString())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return list<Name>
     */
    private function parentsOf(ClassLike $node): array
    {
        if ($node instanceof Class_) {
            return array_values(array_filter(array_merge([$node->extends], $node->implements)));
        }

        if ($node instanceof Interface_) {
            return array_values($node->extends);
        }

        if ($node instanceof Enum_) {
            return array_values($node->implements);
        }

        return [];
    }

    private function isThirdParty(string $className): bool
    {
        if (!$this->reflectionProvider->hasClass($className)) {
            return false;
        }

        $fileName = $this->reflectionProvider->getClass($className)->getFileName();

        if ($fileName === null) {
            return true;
        }

        $path = realpath($fileName) ?: $fileName;

        return str_contains(str_replace('\\', '/', $path), '/vendor/');
    }
}

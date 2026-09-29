<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoBagNameRule;

use SessionHandlerInterface;

class DatabaseSessionHandler implements SessionHandlerInterface
{
    public function open(string $path, string $name): bool
    {
        return true;
    }

    public function close(): bool
    {
        return true;
    }

    public function read(string $id): string|false
    {
        return '';
    }

    public function write(string $id, string $sessionData): bool
    {
        return true;
    }

    public function destroy(string $id): bool
    {
        return true;
    }

    public function gc(int $maxLifetime): int|false
    {
        return 0;
    }
}

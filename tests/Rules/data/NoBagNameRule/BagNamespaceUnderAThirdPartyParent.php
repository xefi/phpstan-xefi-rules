<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\NoBagNameRule\Handlers;

use PhpParser\Error;
use PhpParser\ErrorHandler;

class RefusingErrorHandler implements ErrorHandler
{
    public function handleError(Error $error): void
    {
    }
}

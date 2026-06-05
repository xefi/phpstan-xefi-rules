<?php

namespace Xefi\PHPStanRules\Tests\Rules\data\BooleanPropertyNamingRule;

class NullableBooleanClass
{
    public ?bool $verified = null;
    public bool|null $enabled = null;
    public ?bool $isActive = null;
}

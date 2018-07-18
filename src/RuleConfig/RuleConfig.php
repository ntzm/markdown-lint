<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\RuleConfig;

interface RuleConfig
{
    public static function fromArray(array $config);

    public static function default();
}

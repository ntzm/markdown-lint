<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use Ntzm\MarkdownLint\Rule\Rule;

final class Violation
{
    /** @var Rule */
    private $rule;

    /** @var string */
    private $reason;

    private function __construct(Rule $rule, string $reason)
    {
        $this->rule = $rule;
        $this->reason = $reason;
    }

    public static function fromRule(Rule $rule, string $reason): self
    {
        return new self($rule, $reason);
    }

    public function getRule(): Rule
    {
        return $this->rule;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}

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

    /** @var SourceLocation */
    private $location;

    private function __construct(
        Rule $rule,
        string $reason,
        SourceLocation $location
    ) {
        $this->rule = $rule;
        $this->reason = $reason;
        $this->location = $location;
    }

    public static function fromRule(
        Rule $rule,
        string $reason,
        SourceLocation $location
    ): self {
        return new self($rule, $reason, $location);
    }

    public function getRule(): Rule
    {
        return $this->rule;
    }

    public function getReason(): string
    {
        return $this->reason;
    }

    public function getLocation(): SourceLocation
    {
        return $this->location;
    }
}

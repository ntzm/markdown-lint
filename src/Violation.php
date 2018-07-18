<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use CommonMark\Node;
use Ntzm\MarkdownLint\Rule\Rule;

final class Violation
{
    /** @var Rule */
    private $rule;

    /** @var Node */
    private $violatingNode;

    /** @var string */
    private $reason;

    private function __construct(
        Rule $rule,
        Node $violatingNode,
        string $reason
    ) {
        $this->rule = $rule;
        $this->violatingNode = $violatingNode;
        $this->reason = $reason;
    }

    public static function fromRule(
        Rule $rule,
        Node $violatingNode,
        string $reason
    ): self {
        return new self($rule, $violatingNode, $reason);
    }

    public function getRule(): Rule
    {
        return $this->rule;
    }

    public function getViolatingNode(): Node
    {
        return $this->violatingNode;
    }

    public function getReason(): string
    {
        return $this->reason;
    }
}

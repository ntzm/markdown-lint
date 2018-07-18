<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use CommonMark\Node;
use CommonMark\Node\Document;
use Ntzm\MarkdownLint\Violation;
use Ntzm\MarkdownLint\Violations;

abstract class Rule
{
    abstract public function getViolations(Document $document): Violations;

    protected function violation(string $reason, Node $violatingNode): Violation
    {
        return Violation::fromRule($this, $violatingNode, $reason);
    }
}

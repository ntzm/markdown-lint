<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\Document;
use Ntzm\MarkdownLint\SourceLocation;
use Ntzm\MarkdownLint\Violation;
use Ntzm\MarkdownLint\Violations;

abstract class Rule
{
    abstract public function getViolations(Document $document): Violations;

    protected function violation(
        string $reason,
        SourceLocation $location
    ): Violation {
        return Violation::fromRule($this, $reason, $location);
    }
}

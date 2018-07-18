<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\Document;
use Ntzm\MarkdownLint\Violation;
use Ntzm\MarkdownLint\Violations;

abstract class Rule
{
    abstract public function getViolations(Document $document): Violations;

    protected function generateViolationsFromArray(array $violations): Violations
    {
        return Violations::fromArray(
            array_map(function (string $violation): Violation {
                return Violation::fromRule($this, $violation);
            }, $violations)
        );
    }
}

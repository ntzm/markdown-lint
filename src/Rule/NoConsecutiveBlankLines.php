<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use CommonMark\CQL;
use CommonMark\Node;
use CommonMark\Node\Document;
use Ntzm\MarkdownLint\Violations;

final class NoConsecutiveBlankLines extends Rule
{
    public function getViolations(Document $document): Violations
    {
        $previousNodeEndLine = 1;
        $violations = [];

        $query = new CQL('/children');
        $query($document, function (Document $document, Node $node) use (&$previousNodeEndLine, &$violations): void {
            if ($node->startLine > $previousNodeEndLine + 1) {
                $violations[] = $this->violation('Consecutive blank lines', $node);
            }

            $previousNodeEndLine = $node->endLine;
        });

        return Violations::fromArray($violations);
    }
}

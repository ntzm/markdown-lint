<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use CommonMark\CQL;
use CommonMark\Node;
use CommonMark\Node\Document;
use Ntzm\MarkdownLint\Violations;

final class MaximumLineLength extends Rule
{
    public function getViolations(Document $document): Violations
    {
        $violations = [];

        $query = new CQL('/children');
        $query($document, function (Document $document, Node $node) use (&$violations): void {
            if ($node->endColumn > 80) {
                $violations[] = $this->violation('Line length is over 80', $node);
            }
        });

        return Violations::fromArray($violations);
    }
}

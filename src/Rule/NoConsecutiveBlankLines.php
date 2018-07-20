<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Document;
use Ntzm\MarkdownLint\SourceLocation;
use Ntzm\MarkdownLint\Violations;

final class NoConsecutiveBlankLines extends Rule
{
    public function getViolations(Document $document): Violations
    {
        $previousBlock = $document;
        $violations = [];

        $walker = $document->walker();

        while ($event = $walker->next()) {
            $node = $event->getNode();

            if (!$node instanceof AbstractBlock) {
                continue;
            }

            if ($node->getStartLine() > $previousBlock->getEndLine() + 2) {
                $violations[] = $this->violation(
                    'Consecutive blank lines',
                    SourceLocation::fromBetweenBlocks($previousBlock, $node)
                );
            }

            $previousBlock = $node;
        }

        return Violations::fromArray($violations);
    }
}

<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Document;
use Ntzm\MarkdownLint\NodeIterator;
use Ntzm\MarkdownLint\SourceLocation;
use Ntzm\MarkdownLint\Violation;
use Ntzm\MarkdownLint\Violations;

final class NoConsecutiveBlankLines implements Rule
{
    public function getViolations(Document $document): Violations
    {
        $previousBlock = $document;
        $violations = [];

        $nodes = new NodeIterator($document);

        foreach ($nodes as $node) {
            if (!$node instanceof AbstractBlock) {
                continue;
            }

            if ($node->getStartLine() > $previousBlock->getEndLine() + 2) {
                $violations[] = new Violation(
                    $this,
                    'Consecutive blank lines',
                    SourceLocation::fromBetweenBlocks($previousBlock, $node)
                );
            }

            $previousBlock = $node;
        }

        return Violations::fromArray($violations);
    }
}

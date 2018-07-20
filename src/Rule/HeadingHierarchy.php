<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Element\Heading;
use Ntzm\MarkdownLint\SourceLocation;
use Ntzm\MarkdownLint\Violation;
use Ntzm\MarkdownLint\Violations;

final class HeadingHierarchy implements Rule
{
    public function getViolations(Document $document): Violations
    {
        $currentLevel = 0;
        $violations = [];

        $walker = $document->walker();

        while ($event = $walker->next()) {
            if ($event->isEntering()) {
                continue;
            }

            $node = $event->getNode();

            if (!$node instanceof Heading) {
                continue;
            }

            $level = $node->getLevel();

            // On the same level
            // Example:
            // # Foo
            // # Bar <--
            if ($level === $currentLevel) {
                continue;
            }

            // On a higher level
            // Example:
            // # Foo
            // ## Bar
            // ### Baz
            // # Qux <--
            if ($level < $currentLevel) {
                $currentLevel = $level;

                continue;
            }

            // On one level down
            // Example:
            // # Foo
            // ## Bar <--
            if ($level === $currentLevel + 1) {
                ++$currentLevel;

                continue;
            }

            $violations[] = new Violation(
                $this,
                'Bad heading hierarchy',
                SourceLocation::fromBlock($node)
            );

            $currentLevel = $level;
        }

        return Violations::fromArray($violations);
    }
}

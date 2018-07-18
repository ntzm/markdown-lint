<?php

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Element\Heading;
use Ntzm\MarkdownLint\Violations;

final class HeadingHierarchy extends Rule
{
    public function getViolations(Document $document): Violations
    {
        $violations = [];
        $walker = $document->walker();
        $currentLevel = 0;

        while ($event = $walker->next()) {
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

            // More than one level down
            // Example:
            // # Foo
            // ### Bar <--
            $violations[] = 'Bad hierarchy';
        }

        return $this->generateViolationsFromArray($violations);
    }
}

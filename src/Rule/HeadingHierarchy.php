<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use CommonMark\CQL;
use CommonMark\Node\Document;
use CommonMark\Node\Heading;
use Ntzm\MarkdownLint\Violations;

final class HeadingHierarchy extends Rule
{
    public function getViolations(Document $document): Violations
    {
        $currentLevel = 0;
        $violations = [];

        $query = new CQL('/children(Heading)');
        $query($document, function (Document $document, Heading $heading) use (&$currentLevel, &$violations) {
            // On the same level
            // Example:
            // # Foo
            // # Bar <--
            if ($heading->level === $currentLevel) {
                return true;
            }

            // On a higher level
            // Example:
            // # Foo
            // ## Bar
            // ### Baz
            // # Qux <--
            if ($heading->level < $currentLevel) {
                $currentLevel = $heading->level;

                return true;
            }

            // On one level down
            // Example:
            // # Foo
            // ## Bar <--
            if ($heading->level === $currentLevel + 1) {
                ++$currentLevel;

                return true;
            }

            $violations[] = $this->violation('Bad heading hierarchy', $heading);
            $currentLevel = $heading->level;
        });

        return Violations::fromArray($violations);
    }
}

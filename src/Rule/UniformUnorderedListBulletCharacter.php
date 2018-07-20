<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Element\ListItem;
use Ntzm\MarkdownLint\SourceLocation;
use Ntzm\MarkdownLint\Violation;
use Ntzm\MarkdownLint\Violations;

final class UniformUnorderedListBulletCharacter implements Rule
{
    public function getViolations(Document $document): Violations
    {
        $violations = [];

        $walker = $document->walker();

        while ($event = $walker->next()) {
            if ($event->isEntering()) {
                continue;
            }

            $node = $event->getNode();

            if (!$node instanceof ListItem) {
                continue;
            }

            $character = $this->getBulletCharacter($node);

            if ($character !== null && $character !== '-') {
                $violations[] = new Violation(
                    $this,
                    'Incorrect unordered list bullet character',
                    SourceLocation::fromBlock($node)
                );
            }
        }

        return Violations::fromArray($violations);
    }

    private function getBulletCharacter(ListItem $listItem): ?string
    {
        // TODO: Make PR to get expose list data
        return ((array) $listItem)["\0*\0listData"]->bulletChar;
    }
}

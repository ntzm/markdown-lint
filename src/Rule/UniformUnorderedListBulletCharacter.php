<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\Document;
use League\CommonMark\Block\Element\ListBlock;
use League\CommonMark\Block\Element\ListData;
use League\CommonMark\Block\Element\ListItem;
use Ntzm\MarkdownLint\NodeIterator;
use Ntzm\MarkdownLint\RuleConfig\UniformUnorderedListBulletCharacterConfig;
use Ntzm\MarkdownLint\SourceLocation;
use Ntzm\MarkdownLint\Violation;
use Ntzm\MarkdownLint\Violations;

final class UniformUnorderedListBulletCharacter implements Rule
{
    /** @var UniformUnorderedListBulletCharacterConfig */
    private $config;

    public function __construct(
        UniformUnorderedListBulletCharacterConfig $config = null
    ) {
        $this->config = $config ?? UniformUnorderedListBulletCharacterConfig::default();
    }

    public function getViolations(Document $document): Violations
    {
        $violations = [];

        $nodes = new NodeIterator($document);

        foreach ($nodes as $node) {
            if (!$node instanceof ListItem) {
                continue;
            }

            $listData = $this->getListData($node);

            if ($listData->type !== ListBlock::TYPE_UNORDERED) {
                continue;
            }

            if ($listData->bulletChar === $this->config->getCharacter()) {
                continue;
            }

            $violations[] = new Violation(
                $this,
                'Incorrect unordered list bullet character',
                SourceLocation::fromBlock($node)
            );
        }

        return Violations::fromArray($violations);
    }

    private function getListData(ListItem $listItem): ListData
    {
        // TODO: Make PR to get expose list data
        return ((array) $listItem)["\0*\0listData"];
    }
}

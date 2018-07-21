<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Document;

final class SourceLocation
{
    /** @var int */
    private $startLine;

    /** @var int */
    private $endLine;

    public function __construct(
        int $startLine,
        int $endLine
    ) {
        $this->startLine = $startLine;
        $this->endLine = $endLine;
    }

    public static function fromBlock(AbstractBlock $block): self
    {
        return new self(
            $block->getStartLine(),
            $block->getEndLine()
        );
    }

    public static function fromBetweenBlocks(
        AbstractBlock $blockA,
        AbstractBlock $blockB
    ): self {
        $firstLine = $blockA instanceof Document
            ? 0
            : $blockA->getEndLine();

        return new self(
            $firstLine + 1,
            $blockB->getStartLine() - 1
        );
    }

    public function getStartLine(): int
    {
        return $this->startLine;
    }

    public function getEndLine(): int
    {
        return $this->endLine;
    }
}

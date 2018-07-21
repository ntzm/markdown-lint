<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use ArrayIterator;
use IteratorAggregate;
use League\CommonMark\Block\Element\Document;
use League\CommonMark\Node\Node;

final class NodeIterator implements IteratorAggregate
{
    /** @var Node[] */
    private $nodes = [];

    public function __construct(Document $document)
    {
        $walker = $document->walker();

        while ($event = $walker->next()) {
            if ($event->isEntering()) {
                continue;
            }

            $this->nodes[] = $event->getNode();
        }
    }

    public function getIterator()
    {
        return new ArrayIterator($this->nodes);
    }
}

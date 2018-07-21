<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use League\CommonMark\Block\Element\Document;
use League\CommonMark\Node\Node;
use League\CommonMark\Node\NodeWalker;
use League\CommonMark\Node\NodeWalkerEvent;

final class NodeIterator implements \Iterator
{
    /** @var NodeWalker */
    private $walker;

    /** @var Node */
    private $firstNode;

    /** @var Node|null */
    private $currentNode;

    /** @var int */
    private $index = 0;

    public function __construct(Document $document)
    {
        $this->walker = $document->walker();

        $event = $this->walker->next();

        if (!$event instanceof NodeWalkerEvent) {
            throw new \RuntimeException('This should not happen');
        }

        $this->firstNode = $event->getNode();
        $this->walker->resumeAt($this->firstNode);
    }

    public function current(): ?Node
    {
        return $this->currentNode;
    }

    public function next(): void
    {
        $event = $this->walker->next();

        if (!$event instanceof NodeWalkerEvent) {
            $this->currentNode = null;

            return;
        }

        if ($event->isEntering()) {
            $event = $this->walker->next();
        }

        if (!$event instanceof NodeWalkerEvent) {
            $this->currentNode = null;

            return;
        }

        ++$this->index;
        $this->currentNode = $event->getNode();
    }

    public function key(): int
    {
        return $this->index;
    }

    public function valid(): bool
    {
        return $this->currentNode instanceof Node;
    }

    public function rewind(): void
    {
        $this->index = 0;
        $this->currentNode = $this->firstNode;
        $this->walker->resumeAt($this->currentNode);
    }
}

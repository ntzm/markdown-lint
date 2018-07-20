<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use League\CommonMark\Block\Element\Document;
use Ntzm\MarkdownLint\Violations;

interface Rule
{
    public function getViolations(Document $document): Violations;
}

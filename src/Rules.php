<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use ArrayIterator;
use Assert\Assert;
use IteratorAggregate;
use Ntzm\MarkdownLint\Rule\Rule;

final class Rules implements IteratorAggregate
{
    /** @var Rule[] */
    private $rules;

    private function __construct(array $rules)
    {
        Assert::thatAll($rules)->isInstanceOf(Rule::class);

        $this->rules = $rules;
    }

    public static function fromArray(array $rules): self
    {
        return new self($rules);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->rules);
    }
}

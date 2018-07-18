<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use Ntzm\MarkdownLint\Rule\Rule;
use function CommonMark\Parse;

final class Run
{
    /** @var string */
    private $input;

    /** @var Rules */
    private $rules;

    public function __construct(string $input, Rules $rules)
    {
        $this->input = $input;
        $this->rules = $rules;
    }

    public function getViolations(): Violations
    {
        $document = Parse($this->input);

        $violationsAggregate = [];

        /** @var Rule $rule */
        foreach ($this->rules as $rule) {
            $violationsAggregate[] = $rule->getViolations($document);
        }

        return Violations::combine($violationsAggregate);
    }
}

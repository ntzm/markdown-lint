<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use Ntzm\MarkdownLint\Rule\Rule;

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
        $environment = Environment::createCommonMarkEnvironment();
        $parser = new DocParser($environment);
        $document = $parser->parse($this->input);

        $violationsAggregate = [];

        /** @var Rule $rule */
        foreach ($this->rules as $rule) {
            $violationsAggregate[] = $rule->getViolations($document);
        }

        return Violations::combine($violationsAggregate);
    }
}

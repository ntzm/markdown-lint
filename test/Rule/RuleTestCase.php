<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use Ntzm\MarkdownLint\Rule\Rule;
use Ntzm\MarkdownLint\Violation;
use PHPUnit\Framework\TestCase;

abstract class RuleTestCase extends TestCase
{
    abstract protected function getRuleClass(): string;

    protected function doTest(string $input, array $expectedViolationReasons): void
    {
        $parser = new DocParser(Environment::createCommonMarkEnvironment());
        $document = $parser->parse($input);
        $ruleClass = $this->getRuleClass();
        /** @var Rule $rule */
        $rule = new $ruleClass();

        $this->assertSame(
            $expectedViolationReasons,
            array_map(function (Violation $violation): string {
                return $violation->getReason();
            }, $rule->getViolations($document)->toArray())
        );
    }
}

<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use Ntzm\MarkdownLint\Rule\Rule;
use Ntzm\MarkdownLint\Violation;
use PHPUnit\Framework\TestCase;
use function CommonMark\Parse;

abstract class RuleTestCase extends TestCase
{
    abstract protected function getRuleClass(): string;

    protected function doTest(string $input, array $expectedViolationReasons): void
    {
        $document = Parse($input);
        $ruleClass = $this->getRuleClass();
        /** @var Rule $rule */
        $rule = new $ruleClass();

        $this->assertSame(
            $expectedViolationReasons,
            array_map(function (Violation $violation): array {
                return [
                    $violation->getReason(),
                    $violation->getViolatingNode()->startLine,
                    $violation->getViolatingNode()->endLine,
                    $violation->getViolatingNode()->startColumn,
                    $violation->getViolatingNode()->endColumn,
                ];
            }, $rule->getViolations($document)->toArray())
        );
    }
}

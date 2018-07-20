<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use Ntzm\MarkdownLint\Rule\NoConsecutiveBlankLines;

/**
 * @covers \Ntzm\MarkdownLint\Rule\NoConsecutiveBlankLines
 */
final class NoConsecutiveBlankLinesTest extends RuleTestCase
{
    /** @dataProvider provideCases */
    public function test(string $input, array $expectedViolationMessages): void
    {
        $this->doTest($input, $expectedViolationMessages);
    }

    public function provideCases(): array
    {
        return [
            [
                '',
                [],
            ],
            [
                '
foo',
                [],
            ],
            [
                'foo

bar',
                [],
            ],
            [
                '# foo


# bar',
                [
                    ['Consecutive blank lines', 2, 3],
                ],
            ],
            [
                'foo


bar',
                [
                    ['Consecutive blank lines', 2, 3],
                ],
            ],
            [
                '

foo',
                [
                    ['Consecutive blank lines', 1, 2],
                ],
            ],
        ];
    }

    protected function getRuleClass(): string
    {
        return NoConsecutiveBlankLines::class;
    }
}

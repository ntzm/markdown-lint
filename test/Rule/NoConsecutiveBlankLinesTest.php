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
                "\nfoo",
                [],
            ],
            [
                "# foo\n\n# bar",
                [
                    ['Consecutive blank lines', 3, 3, 1, 5],
                ],
            ],
            [
                "foo\n\nbar",
                [
                    ['Consecutive blank lines', 3, 3, 1, 3],
                ],
            ],
            [
                "\n\nfoo",
                [
                    ['Consecutive blank lines', 3, 3, 1, 3],
                ],
            ],
        ];
    }

    protected function getRuleClass(): string
    {
        return NoConsecutiveBlankLines::class;
    }
}

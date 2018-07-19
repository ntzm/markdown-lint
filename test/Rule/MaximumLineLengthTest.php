<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use Ntzm\MarkdownLint\Rule\MaximumLineLength;

/**
 * @covers \Ntzm\MarkdownLint\Rule\MaximumLineLength
 */
final class MaximumLineLengthTest extends RuleTestCase
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
                str_repeat('a', 80),
                [],
            ],
            [
                str_repeat('a', 81),
                [
                    ['Line length is over 80', 1, 1, 1, 81],
                ],
            ],
        ];
    }

    protected function getRuleClass(): string
    {
        return MaximumLineLength::class;
    }
}

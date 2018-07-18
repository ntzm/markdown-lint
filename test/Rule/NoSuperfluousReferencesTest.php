<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use Ntzm\MarkdownLint\Rule\NoSuperfluousReferences;

/**
 * @covers \Ntzm\MarkdownLint\Rule\NoSuperfluousReferences
 */
final class NoSuperfluousReferencesTest extends RuleTestCase
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
                "[foo]\n[foo]: /bar",
                [],
            ],
            [
                "# [foo]\n[foo]: /bar",
                [],
            ],
            [
                "- [foo]\n[foo]: /bar",
                [],
            ],
            [
                '[foo]: /bar',
                ['Unused reference label [FOO]'],
            ],
            [
                '[💩]: /bar',
                ['Unused reference label [💩]'],
            ],
            [
                '[αλώπηξ]: /bar',
                ['Unused reference label [ΑΛΏΠΗΞ]'],
            ],
            [
                "[αλώπηξ]\n[αλώπηξ]: /bar",
                [],
            ],
        ];
    }

    protected function getRuleClass(): string
    {
        return NoSuperfluousReferences::class;
    }
}

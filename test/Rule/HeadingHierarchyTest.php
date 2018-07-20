<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use Ntzm\MarkdownLint\Rule\HeadingHierarchy;

/**
 * @covers \Ntzm\MarkdownLint\Rule\HeadingHierarchy
 */
final class HeadingHierarchyTest extends RuleTestCase
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
                '# foo',
                [],
            ],
            [
                '## foo',
                [
                    ['Bad heading hierarchy', 1, 1],
                ],
            ],
            [
                "## foo\n\n## bar",
                [
                    ['Bad heading hierarchy', 1, 1],
                ],
            ],
            [
                "# foo\n\n# bar",
                [],
            ],
            [
                "# foo\n\n## bar\n\n### baz\n\n#qux",
                [],
            ],
            [
                "# foo\n\n### bar",
                [
                    ['Bad heading hierarchy', 3, 3],
                ],
            ],
        ];
    }

    protected function getRuleClass(): string
    {
        return HeadingHierarchy::class;
    }
}

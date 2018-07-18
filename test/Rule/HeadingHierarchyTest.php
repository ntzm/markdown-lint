<?php

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
                ['Bad hierarchy'],
            ],
        ];
    }

    protected function getRuleClass(): string
    {
        return HeadingHierarchy::class;
    }
}
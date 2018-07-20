<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use Ntzm\MarkdownLint\Rule\UniformUnorderedListBulletCharacter;

/**
 * @covers \Ntzm\MarkdownLint\Rule\UniformUnorderedListBulletCharacter
 */
final class UniformUnorderedListBulletCharacterTest extends RuleTestCase
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
                '- foo',
                [],
            ],
            [
                '1. foo',
                [],
            ],
            [
                '* foo',
                [
                    ['Incorrect unordered list bullet character', 1, 1],
                ],
            ],
        ];
    }

    protected function getRuleClass(): string
    {
        return UniformUnorderedListBulletCharacter::class;
    }
}

<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use Ntzm\MarkdownLint\Rule\UniformUnorderedListBulletCharacter;
use Ntzm\MarkdownLint\RuleConfig\UniformUnorderedListBulletCharacterConfig;

/**
 * @covers \Ntzm\MarkdownLint\Rule\UniformUnorderedListBulletCharacter
 */
final class UniformUnorderedListBulletCharacterTest extends RuleTestCase
{
    /** @dataProvider provideCases */
    public function test(
        string $input,
        ?array $config,
        array $expectedViolationMessages
    ): void {
        $this->doTest($input, $expectedViolationMessages, $config);
    }

    public function provideCases(): array
    {
        return [
            [
                '',
                null,
                [],
            ],
            [
                '- foo',
                null,
                [],
            ],
            [
                '1. foo',
                null,
                [],
            ],
            [
                '* foo',
                null,
                [
                    ['Incorrect unordered list bullet character', 1, 1],
                ],
            ],
            [
                '# Foo

* bar',
                null,
                [
                    ['Incorrect unordered list bullet character', 3, 3],
                ],
            ],
            [
                '* foo
- bar
* baz',
                null,
                [
                    ['Incorrect unordered list bullet character', 1, 1],
                    ['Incorrect unordered list bullet character', 3, 3],
                ],
            ],
            [
                '* foo
- bar
* baz',
                ['character' => '*'],
                [
                    ['Incorrect unordered list bullet character', 2, 2],
                ],
            ],
        ];
    }

    protected function getRuleClass(): string
    {
        return UniformUnorderedListBulletCharacter::class;
    }

    protected function getRuleConfigClass(): string
    {
        return UniformUnorderedListBulletCharacterConfig::class;
    }
}

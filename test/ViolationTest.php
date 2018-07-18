<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint;

use League\CommonMark\Block\Element\Document;
use Ntzm\MarkdownLint\Rule\Rule;
use Ntzm\MarkdownLint\Violation;
use Ntzm\MarkdownLint\Violations;
use PHPUnit\Framework\TestCase;

final class ViolationTest extends TestCase
{
    public function testGetRule(): void
    {
        $rule = $this->mockRule();
        $violation = Violation::fromRule($rule, 'foo');

        $this->assertSame($rule, $violation->getRule());
    }

    public function testGetReason(): void
    {
        $violation = Violation::fromRule($this->mockRule(), 'foo');

        $this->assertSame('foo', $violation->getReason());
    }

    private function mockRule(): Rule
    {
        return new class() extends Rule {
            public function getViolations(Document $document): Violations
            {
                return Violations::empty();
            }
        };
    }
}

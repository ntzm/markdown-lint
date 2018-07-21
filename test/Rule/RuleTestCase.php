<?php

declare(strict_types=1);

namespace NtzmTest\MarkdownLint\Rule;

use Assert\Assert;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use Ntzm\MarkdownLint\Rule\Rule;
use Ntzm\MarkdownLint\Violation;
use PHPUnit\Framework\TestCase;

abstract class RuleTestCase extends TestCase
{
    abstract protected function getRuleClass(): string;

    protected function getRuleConfigClass(): ?string
    {
        return null;
    }

    protected function doTest(
        string $input,
        array $expectedViolationReasons,
        array $config = null
    ): void {
        $environment = Environment::createCommonMarkEnvironment();
        $parser = new DocParser($environment);
        $document = $parser->parse($input);
        $ruleClass = $this->getRuleClass();

        if ($config === null) {
            /** @var Rule $rule */
            $rule = new $ruleClass();
        } else {
            $configClass = $this->getRuleConfigClass();
            Assert::that($configClass)->string($configClass);
            $config = $configClass::fromArray($config);
            $rule = new $ruleClass($config);
        }

        $this->assertSame(
            $expectedViolationReasons,
            array_map(function (Violation $violation): array {
                return [
                    $violation->getReason(),
                    $violation->getLocation()->getStartLine(),
                    $violation->getLocation()->getEndLine(),
                ];
            }, $rule->getViolations($document)->toArray())
        );
    }
}

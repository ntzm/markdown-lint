<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint;

use Assert\Assert;

final class Violations
{
    /** @var Violation[] */
    private $violations;

    private function __construct(array $violations)
    {
        Assert::thatAll($violations)->isInstanceOf(Violation::class);

        $this->violations = $violations;
    }

    public static function fromArray(array $violations): self
    {
        return new self($violations);
    }

    public static function empty(): self
    {
        return new self([]);
    }

    /** @param self[] $violationsAggregate */
    public static function combine(array $violationsAggregate): self
    {
        Assert::thatAll($violationsAggregate)->isInstanceOf(self::class);

        $combinedViolations = [];

        foreach ($violationsAggregate as $violations) {
            $combinedViolations = array_merge(
                $combinedViolations,
                $violations->toArray()
            );
        }

        return new self($combinedViolations);
    }

    /** @return Violation[] */
    public function toArray(): array
    {
        return $this->violations;
    }
}

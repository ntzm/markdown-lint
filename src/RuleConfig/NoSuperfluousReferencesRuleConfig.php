<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\RuleConfig;

final class NoSuperfluousReferencesRuleConfig implements RuleConfig
{
    /** @var string[] */
    private $ignoredLabels;

    private function __construct(array $ignoredLabels)
    {
        $this->ignoredLabels = array_map('strtoupper', $ignoredLabels);
    }

    public static function fromArray(array $config): self
    {
        return new self(
            $config['ignored_labels'] ?? []
        );
    }

    public static function default(): self
    {
        return new self([]);
    }

    /** @return string[] */
    public function getIgnoredLabels(): array
    {
        return $this->ignoredLabels;
    }
}

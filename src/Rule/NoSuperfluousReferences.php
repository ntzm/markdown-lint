<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\Rule;

use Assert\Assert;
use League\CommonMark\Block\Element\Document;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Element\Text;
use League\CommonMark\Reference\Reference;
use Ntzm\MarkdownLint\RuleConfig\NoSuperfluousReferencesRuleConfig;
use Ntzm\MarkdownLint\Violations;

final class NoSuperfluousReferences extends Rule
{
    /** @var NoSuperfluousReferencesRuleConfig */
    private $config;

    public function __construct(?NoSuperfluousReferencesRuleConfig $config = null)
    {
        $this->config = $config ?? NoSuperfluousReferencesRuleConfig::default();
    }

    public function getViolations(Document $document): Violations
    {
        $referenceLabels = $this->getReferenceLabels($document);
        $usedReferenceLabels = [];

        $walker = $document->walker();

        while ($event = $walker->next()) {
            $node = $event->getNode();

            if (!$node instanceof Link) {
                continue;
            }

            /** @var Text $textNode */
            $textNode = $node->firstChild();
            Assert::that($textNode)->isInstanceOf(Text::class);

            $usedReferenceLabels[] = strtoupper($textNode->getContent());
        }

        return $this->generateViolationsFromUnusedReferenceLabels(
            array_diff(
                $referenceLabels,
                $usedReferenceLabels,
                $this->config->getIgnoredLabels()
            )
        );
    }

    private function getReferenceLabels(Document $document): array
    {
        return array_map(function (Reference $reference): string {
            return $reference->getLabel();
        }, $document->getReferenceMap()->listReferences());
    }

    private function generateViolationsFromUnusedReferenceLabels(array $unusedReferenceLabels): Violations
    {
        return $this->generateViolationsFromArray(
            array_map(function (string $unusedReferenceLabel): string {
                return "Unused reference label [{$unusedReferenceLabel}]";
            }, $unusedReferenceLabels)
        );
    }
}

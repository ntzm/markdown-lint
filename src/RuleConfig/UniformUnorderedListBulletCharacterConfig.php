<?php

declare(strict_types=1);

namespace Ntzm\MarkdownLint\RuleConfig;

use Assert\Assert;

final class UniformUnorderedListBulletCharacterConfig implements RuleConfig
{
    public const CHARACTER_DASH = '-';
    public const CHARACTER_ASTERISK = '*';
    public const CHARACTER_DEFAULT = self::CHARACTER_DASH;

    /** @var string */
    private $character;

    private function __construct(string $character)
    {
        Assert::that($character)->inArray([self::CHARACTER_DASH, self::CHARACTER_ASTERISK]);

        $this->character = $character;
    }

    public static function fromArray(array $config): self
    {
        return new self($config['character']);
    }

    public static function default(): self
    {
        return new self(self::CHARACTER_DEFAULT);
    }

    public function getCharacter(): string
    {
        return $this->character;
    }
}

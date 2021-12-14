<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams;

use JsonSerializable;

/**
 * Class AbstractCard
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
abstract class AbstractCard implements JsonSerializable
{
    const MESSAGE_CONTEXT = 'http://schema.org/extensions';

    private string $themeColor = ThemeColor::INFO;

    /** Returns the card type */
    abstract public function getType(): string;

    /** Returns additional data for jsonSerialize */
    abstract protected function getAdditionalJsonData(): array;

    /** Get the theme color */
    public function getThemeColor(): string
    {
        return $this->themeColor;
    }

    /** Set the theme color */
    public function setThemeColor(string $themeColor): self
    {
        $this->themeColor = $themeColor;
        return $this;
    }

    /** @inheritDoc */
    public function jsonSerialize(): array
    {
        return array_merge([
            '@type' => $this->getType(),
            '@context' => self::MESSAGE_CONTEXT,
            'themeColor' => $this->getThemeColor(),
        ], $this->getAdditionalJsonData());
    }
}
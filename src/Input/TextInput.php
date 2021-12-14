<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams\Input;

/**
 * Class TextInput
 * @package LupusCoding\Webhooks\Teams\Input
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class TextInput extends AbstractActionInput
{
    private bool $multiline = false;

    /** @inheritDoc */
    public function getType(): string
    {
        return 'TextInput';
    }

    /** Check if text is multiline */
    public function isMultiline(): bool
    {
        return $this->multiline;
    }

    /** Set multiline option to true or false */
    public function setMultiline(bool $isMultiline): TextInput
    {
        $this->multiline = $isMultiline;
        return $this;
    }

    /** @inheritDoc */
    protected function getAdditionalJsonData(): array
    {
        return [
            'isMultiline' => $this->isMultiline(),
        ];
    }

}
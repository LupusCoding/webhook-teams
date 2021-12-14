<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams\Input;

/**
 * Class MultichoiceInput
 * @package LupusCoding\Webhooks\Teams\Input
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class MultichoiceInput extends AbstractActionInput
{
    private bool $multiselect = false;
    private array $choices = [];

    /** @inheritDoc */
    public function getType(): string
    {
        return 'MultichoiceInput';
    }

    /** Check if input is multiselect */
    public function isMultiselect(): bool
    {
        return $this->multiselect;
    }

    /** Set multiselect option to true or false */
    public function setMultiselect(bool $isMultiselect): MultichoiceInput
    {
        $this->multiselect = $isMultiselect;
        return $this;
    }

    /** Add a choice to input */
    public function addChoice(string $display, string $value): MultichoiceInput
    {
        $this->choices[] = [
            'display' => $display,
            'value' => $value,
        ];
        return $this;
    }

    /** Get input choices
     * @return array[]
     */
    public function getChoices(): array
    {
        return $this->choices;
    }

    /** @inheritDoc */
    protected function getAdditionalJsonData(): array
    {
        return [
            'isMultiSelect' => $this->isMultiselect(),
            'choices' => $this->getChoices(),
        ];
    }
}
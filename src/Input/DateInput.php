<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams\Input;

/**
 * Class DateInput
 * @package LupusCoding\Webhooks\Teams\Input
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class DateInput extends AbstractActionInput
{
    /** @inheritDoc */
    public function getType(): string
    {
        return 'DateInput';
    }

    /** @inheritDoc */
    protected function getAdditionalJsonData(): array
    {
        return [];
    }
}
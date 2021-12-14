<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams\CardAction;

use LupusCoding\Webhooks\Teams\CardActionInterface;

/**
 * Class AbstractCardAction
 * @package LupusCoding\Webhooks\Teams\Action
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
abstract class AbstractCardAction implements CardActionInterface
{
    private string $name = '';

    /** @inheritDoc */
    public function getName(): string
    {
        return $this->name;
    }

    /** @inheritDoc */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /** Returns additional data for jsonSerialize */
    abstract protected function getAdditionalJsonData(): array;

    /** @inheritDoc */
    public function jsonSerialize(): array
    {
        return array_merge([
            '@type' => $this->getType(),
            'name' => $this->getName(),
        ], $this->getAdditionalJsonData());
    }
}
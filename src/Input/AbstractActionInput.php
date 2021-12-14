<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams\Input;

use LupusCoding\Webhooks\Teams\ActionInputInterface;

/**
 * Class AbstractActionInput
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
abstract class AbstractActionInput implements ActionInputInterface
{
    private string $id = '';
    private string $title = '';

    /** @inheritDoc */
    public function getId(): string
    {
        return $this->id;
    }

    /** @inheritDoc */
    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    /** @inheritDoc */
    public function getTitle(): string
    {
        return $this->title;
    }

    /** @inheritDoc */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    /** Returns additional data for jsonSerialize */
    abstract protected function getAdditionalJsonData(): array;

    /** @inheritDoc */
    public function jsonSerialize(): array
    {
        return array_merge([
            '@type' => $this->getType(),
            'id' => $this->getId(),
            'title' => $this->getTitle(),
        ], $this->getAdditionalJsonData());
    }
}
<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams\MessageAction;

use LupusCoding\Webhooks\Teams\MessageActionInterface;

/**
 * Class OpenUri
 * @package LupusCoding\Webhooks\Teams\MessageAction
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class OpenUri implements MessageActionInterface
{
    private string $name = '';
    /** @var array[] */
    private array $targets = [];

    /** @inheritDoc */
    public function getType(): string
    {
        return 'OpenUri';
    }

    /** @inheritDoc */
    public function getName(): string
    {
        return $this->name;
    }

    /** @inheritDoc */
    public function setName(string $name): MessageActionInterface
    {
        $this->name = $name;
        return $this;
    }

    /** Set a link target per OS */
    public function addTarget(string $uri, string $os = 'default'): OpenUri
    {
        $this->targets[] = [
            'os' => $os,
            'uri' => $uri,
        ];
        return $this;
    }

    /** Get the link targets
     * @return array[]
     */
    public function getTargets(): array
    {
        return $this->targets;
    }

    /** @inheritDoc */
    public function jsonSerialize()
    {
        if (empty($this->getTargets())) {
            $this->targets[] = [];
        }
        return [
            '@type' => $this->getType(),
            'name' => $this->getName(),
            'targets' => $this->getTargets(),
        ];
    }

}
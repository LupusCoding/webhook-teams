<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams\CardAction;

/**
 * Class HttpPost
 * @package LupusCoding\Webhooks\Teams\Action
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class HttpPost extends AbstractCardAction
{
    private string $target = '';

    /** @inheritDoc */
    public function getType(): string
    {
        return 'HttpPOST';
    }

    /** Get the target link */
    public function getTarget(): string
    {
        return $this->target;
    }

    /** Set the target link */
    public function setTarget(string $target): HttpPost
    {
        $this->target = $target;
        return $this;
    }

    /** @inheritDoc */
    protected function getAdditionalJsonData(): array
    {
        return [
            'target' => $this->getTarget(),
        ];
    }

}
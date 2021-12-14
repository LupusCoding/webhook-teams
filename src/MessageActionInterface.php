<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams;

use JsonSerializable;

/**
 * Interface MessageActionInterface
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
interface MessageActionInterface extends JsonSerializable
{
    /** Returns the message action type (for example: ActionCard or OpenUri) */
    public function getType(): string;
    /** Get the action name */
    public function getName(): string;
    /** Set the action name */
    public function setName(string $name): self;
}
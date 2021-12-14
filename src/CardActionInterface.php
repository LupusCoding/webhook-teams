<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams;

use JsonSerializable;

/**
 * Interface CardActionInterface
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
interface CardActionInterface extends JsonSerializable
{
    /** Returns the action type (for example: HttpPOST) */
    public function getType(): string;
    /** Get the button name */
    public function getName(): string;
    /** Set the button name */
    public function setName(string $name): self;
}
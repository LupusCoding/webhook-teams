<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams;

use JsonSerializable;

/**
 * Interface ActionInputInterface
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
interface ActionInputInterface extends JsonSerializable
{
    /** Return the action input type */
    public function getType(): string;
    /** Get the input ID */
    public function getId(): string;
    /** Set the input ID */
    public function setId(string $id): self;
    /** Get the input title */
    public function getTitle(): string;
    /** Set the input title */
    public function setTitle(string $title): self;
}
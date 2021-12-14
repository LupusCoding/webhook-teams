<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams;

use JsonSerializable;

/**
 * Class MessageSection
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class MessageSection implements JsonSerializable
{
    private string $activityTitle = '';
    private string $activitySubtitle = '';
    private string $activityImage = '';
    /** @var array[] */
    private array $facts = [];
    private bool $markdown = true;

    /** Get the activity title */
    public function getActivityTitle(): string
    {
        return $this->activityTitle;
    }

    /** Set the activity title */
    public function setActivityTitle(string $activityTitle): MessageSection
    {
        $this->activityTitle = $activityTitle;
        return $this;
    }

    /** Get the activity subtitle */
    public function getActivitySubtitle(): string
    {
        return $this->activitySubtitle;
    }

    /** Set an activity subtitle */
    public function setActivitySubtitle(string $activitySubtitle): MessageSection
    {
        $this->activitySubtitle = $activitySubtitle;
        return $this;
    }

    /** Get the activity image */
    public function getActivityImage(): string
    {
        return $this->activityImage;
    }

    /** Set the activity image */
    public function setActivityImage(string $activityImage): MessageSection
    {
        $this->activityImage = $activityImage;
        return $this;
    }

    /** Get the section facts
     * @return array[]
     */
    public function getFacts(): array
    {
        return $this->facts;
    }

    /** Add a section fact */
    public function addFact(string $name, string $value): MessageSection
    {
        $this->facts[] = [
            'name' => $name,
            'value' => $value,
        ];
        return $this;
    }

    /** Check if markdown is true */
    public function isMarkdown(): bool
    {
        return $this->markdown;
    }

    /** Set message markdown to true or false */
    public function setMarkdown(bool $isMarkdown): MessageSection
    {
        $this->markdown = $isMarkdown;
        return $this;
    }

    /** @inheritDoc */
    public function jsonSerialize(): array
    {
        return [
            'activityTitle' => $this->getActivityTitle(),
            'activitySubtitle' => $this->getActivitySubtitle(),
            'activityImage' => $this->getActivityImage(),
            'facts' => $this->getFacts(),
            'markdown' => $this->isMarkdown(),
        ];
    }

}
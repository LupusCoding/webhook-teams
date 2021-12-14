<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams;

/**
 * Class MessageCard
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class MessageCard extends AbstractCard
{
    private string $summary = '';
    /** @var MessageSection[] */
    private array $sections = [];
    /** @var MessageActionInterface[] */
    private array $potentialAction = [];

    /** @inheritDoc */
    public function getType(): string
    {
        return 'MessageCard';
    }

    /** Get the message summary */
    public function getSummary(): string
    {
        return $this->summary;
    }

    /** Set the message summary */
    public function setSummary(string $summary): MessageCard
    {
        $this->summary = $summary;
        return $this;
    }

    /** Add a message section */
    public function addSection(MessageSection $section): MessageCard
    {
        $this->sections[] = $section;
        return $this;
    }

    /** Get the message sections
     * @return MessageSection[]
     */
    public function getSections(): array
    {
        return $this->sections;
    }

    /** Add a new potential action */
    public function addPotentialAction(MessageActionInterface $potentialAction): MessageCard
    {
        $this->potentialAction[] = $potentialAction;
        return $this;
    }

    /** Get the potential actions
     * @return MessageActionInterface[]
     */
    public function getPotentialActions(): array
    {
        return $this->potentialAction;
    }

    /** @inheritDoc */
    protected function getAdditionalJsonData(): array
    {
        $data = [
            'summary' => $this->getSummary(),
            'sections' => $this->getSections(),
            'potentialAction' => $this->getPotentialActions(),
        ];
        if (empty($this->getSections())) {
            unset($data['sections']);
        }
        if (empty($this->getPotentialActions())) {
            unset($data['potentialAction']);
        }
        return $data;
    }

}
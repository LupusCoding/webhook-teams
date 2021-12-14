<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\Teams;

/**
 * Class ActionCard
 * @package LupusCoding\Webhooks\Teams
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class ActionCard extends AbstractCard implements MessageActionInterface
{
    private string $name = '';
    /** @var ActionInputInterface[] */
    private array $inputs = [];
    /** @var CardActionInterface[] */
    private array $actions = [];

    /** @inheritDoc */
    public function getType(): string
    {
        return 'ActionCard';
    }

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

    /** Add an input to the card */
    public function addInput(ActionInputInterface $input): self
    {
        $this->inputs[] = $input;
        return $this;
    }

    /** Get the cards' inputs
     * @return ActionInputInterface[]
     */
    public function getInputs(): array
    {
        return $this->inputs;
    }

    /** Add an action to the card */
    public function addAction(CardActionInterface $action): self
    {
        $this->actions[] = $action;
        return $this;
    }

    /** Get the cards' actions
     * @return CardActionInterface[]
     */
    public function getActions(): array
    {
        return $this->actions;
    }

    /** @inheritDoc */
    protected function getAdditionalJsonData(): array
    {
        $data = [
            'name' => $this->getName(),
            'inputs' => $this->getInputs(),
            'actions' => $this->getActions(),
        ];
        if (empty($this->getInputs())) {
            unset($data['inputs']);
        }
        if (empty($this->getActions())) {
            unset($data['actions']);
        }
        return $data;
    }

}
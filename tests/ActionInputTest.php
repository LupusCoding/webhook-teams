<?php

declare(strict_types=1);

use LupusCoding\Webhooks\Teams\Input\DateInput;
use LupusCoding\Webhooks\Teams\Input\MultichoiceInput;
use LupusCoding\Webhooks\Teams\Input\TextInput;
use PHPUnit\Framework\TestCase;

/**
 * Class ActionInputTest
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class ActionInputTest extends TestCase
{

    /**
     * @covers \LupusCoding\Webhooks\Teams\Input\DateInput
     */
    public function testCanSetupDateInput(): void
    {
        $input = $this->createDateInput();
        $this->assertEquals('DateInput', $input->getType());
        $this->assertEquals('date1', $input->getId());
        $this->assertEquals('Choose a date', $input->getTitle());
    }

    private function createDateInput(): DateInput
    {
        $input = new DateInput();
        return $input->setId('date1')
            ->setTitle('Choose a date')
            ;
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\Input\MultichoiceInput
     */
    public function testCanSetupMultichoiceInput(): void
    {
        $input = $this->createMultichoiceInput();
        $this->assertEquals('MultichoiceInput', $input->getType());
        $this->assertEquals('choice1', $input->getId());
        $this->assertEquals('Choose wisely', $input->getTitle());
        $this->assertEquals(['display' => 'Option 1', 'value' => '1'], $input->getChoices()[0]);
        $this->assertEquals(['display' => 'Option 2', 'value' => '2'], $input->getChoices()[1]);
        $this->assertTrue($input->isMultiselect());
    }

    private function createMultichoiceInput(): MultichoiceInput
    {
        $input = new MultichoiceInput();
        return $input->setId('choice1')
            ->setTitle('Choose wisely')
            ->setMultiselect(true)
            ->addChoice('Option 1', '1')
            ->addChoice('Option 2', '2')
            ;
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\Input\TextInput
     */
    public function testCanSetupTextInput(): void
    {
        $input = $this->createTextInput();
        $this->assertEquals('TextInput', $input->getType());
        $this->assertEquals('comment', $input->getId());
        $this->assertEquals('Add a comment', $input->getTitle());
        $this->assertTrue($input->isMultiline());
    }

    private function createTextInput(): TextInput
    {
        $input = new TextInput();
        return $input->setId('comment')
            ->setTitle('Add a comment')
            ->setMultiline(true)
            ;
    }

}
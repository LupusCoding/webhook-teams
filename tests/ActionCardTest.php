<?php

declare(strict_types=1);

namespace LupusCoding\Webhooks\TeamsTests;

use LupusCoding\Webhooks\Teams\AbstractCard;
use LupusCoding\Webhooks\Teams\ActionCard;
use LupusCoding\Webhooks\Teams\CardAction\HttpPost;
use LupusCoding\Webhooks\Teams\Input\TextInput;
use LupusCoding\Webhooks\TeamsTests\SenderLib\Sender;
use LupusCoding\Webhooks\Teams\ThemeColor;
use PHPUnit\Framework\TestCase;

/**
 * Class ActionCardTest
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class ActionCardTest extends TestCase
{
    const WEBHOOK_URL = 'https://enlkvoeh7ebfj64.m.pipedream.net';

    /**
     * @covers \LupusCoding\Webhooks\Teams\ActionCard
     */
    public function testCanCreateMessageCard(): void
    {
        $card = new ActionCard();
        $this->assertInstanceOf(ActionCard::class, $card);
        $this->assertEquals('ActionCard', $card->getType());

        $card->setThemeColor(ThemeColor::SUCCESS)
            ->setName('Example action');
        $this->assertEquals(ThemeColor::SUCCESS, $card->getThemeColor());
        $this->assertEquals('Example action', $card->getName());
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\ActionCard
     * @covers \LupusCoding\Webhooks\Teams\Input\TextInput
     */
    public function testCanCreateAndAddInput(): void
    {
        $card = new ActionCard();
        $card->addInput( new TextInput() );
        $this->assertInstanceOf(TextInput::class, $card->getInputs()[0]);
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\ActionCard
     * @covers \LupusCoding\Webhooks\Teams\CardAction\HttpPost
     */
    public function testCanCreateAndAddAction(): void
    {
        $card = new ActionCard();
        $card->addAction( new HttpPost() );
        $this->assertInstanceOf(HttpPost::class, $card->getActions()[0]);
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\ActionCard
     */
    public function testCanSerializeMinimalCard(): void
    {
        $card = new ActionCard();
        $this->assertEquals(
            json_encode([
                '@type' => 'ActionCard',
                '@context' => AbstractCard::MESSAGE_CONTEXT,
                'themeColor' => ThemeColor::INFO,
                'name' => '',
            ]),
            json_encode($card)
        );
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\ActionCard
     * @covers \LupusCoding\Webhooks\Teams\Input\TextInput
     * @covers \LupusCoding\Webhooks\Teams\CardAction\HttpPost
     */
    public function testCanSerializeFullCard(): void
    {
        $card = new ActionCard();
        $card->setName('action1')
            ->setThemeColor(ThemeColor::DEBUG);
        $card->addInput( $this->createTextInput() );
        $card->addAction( $this->createHttpPostAction() );
        $assertData = $this->getSerializationAssertionData();
        $this->assertEquals(
            json_encode($assertData),
            json_encode($card)
        );
    }

    private function createTextInput(): TextInput
    {
        $input = new TextInput();
        return $input->setId('input1')
            ->setTitle('Type something in')
            ->setMultiline(true)
            ;
    }

    private function createHttpPostAction(): HttpPost
    {
        $action = new HttpPost();
        return $action->setName('Click me')
            ->setTarget('http://lupuscoding.de');
    }

    private function getSerializationAssertionData(): array
    {
        return [
            '@type' => 'ActionCard',
            '@context' => AbstractCard::MESSAGE_CONTEXT,
            'themeColor' => ThemeColor::DEBUG,
            'name' => 'action1',
            'inputs' => [
                [
                    '@type' => 'TextInput',
                    'id' => 'input1',
                    'title' => 'Type something in',
                    'isMultiline' => true,
                ],
            ],
            'actions' => [
                [
                    '@type' => 'HttpPOST',
                    'name' => 'Click me',
                    'target' => 'http://lupuscoding.de',
                ],
            ],
        ];
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\ActionCard
     * @covers \LupusCoding\Webhooks\Teams\Input\TextInput
     * @covers \LupusCoding\Webhooks\Teams\CardAction\HttpPost
     */
    public function testSendActionCard(): void
    {
        $card = new ActionCard();
        $card->setName('phpunit-test')
            ->setThemeColor(ThemeColor::DEBUG)
            ->addInput( $this->createTextInput() )
            ->addAction( $this->createHttpPostAction() );

        $sender = new Sender(self::WEBHOOK_URL);
        $sender->send($card);

        $this->assertTrue($sender->isSuccess());
        $this->assertEquals('ActionCard', $sender->getBody()['type']);
    }
}
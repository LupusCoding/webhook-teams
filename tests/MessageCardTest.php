<?php

declare(strict_types=1);

use LupusCoding\Webhooks\Teams\AbstractCard;
use LupusCoding\Webhooks\Teams\MessageAction\OpenUri;
use LupusCoding\Webhooks\Teams\MessageCard;
use LupusCoding\Webhooks\Teams\MessageSection;
use LupusCoding\Webhooks\Teams\ThemeColor;
use PHPUnit\Framework\TestCase;

/**
 * Class MessageCardTest
 * @author Ralph Dittrich <dittrich.ralph@lupuscoding.de>
 */
class MessageCardTest extends TestCase
{
    const WEBHOOK_URL = 'https://webhook.site/253013d5-4960-4857-85c4-596998c26e10';

    /**
     * @covers \LupusCoding\Webhooks\Teams\MessageCard
     */
    public function testCanCreateMessageCard(): void
    {
        $card = new MessageCard();
        $this->assertInstanceOf(MessageCard::class, $card);
        $this->assertEquals('MessageCard', $card->getType());

        $card->setThemeColor(ThemeColor::DEBUG)
            ->setSummary('This is a summary');
        $this->assertEquals(ThemeColor::DEBUG, $card->getThemeColor());
        $this->assertEquals('This is a summary', $card->getSummary());
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\MessageCard
     * @covers \LupusCoding\Webhooks\Teams\MessageSection
     */
    public function testCanCreateAndAddSections(): void
    {
        $card = new MessageCard();
        $card->addSection( new MessageSection() );
        $this->assertInstanceOf(MessageSection::class, $card->getSections()[0]);

    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\MessageCard
     * @covers \LupusCoding\Webhooks\Teams\MessageSection
     */
    public function testCanSetupSection(): void
    {
        $section = $this->createMessageSection();
        $this->assertEquals('Test activity', $section->getActivityTitle());
        $this->assertEquals('This is a unit test', $section->getActivitySubtitle());
        $this->assertEquals('activity.png', $section->getActivityImage());
        $this->assertEquals([
            'name' => 'Test fact',
            'value' => 'This is a fact',
        ], $section->getFacts()[0]);
        $this->assertFalse($section->isMarkdown());
    }

    private function createMessageSection(): MessageSection
    {
        $section = new MessageSection();
        return $section->setActivityTitle('Test activity')
            ->setActivitySubtitle('This is a unit test')
            ->setActivityImage('activity.png')
            ->addFact('Test fact', 'This is a fact')
            ->setMarkdown(false);
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\MessageCard
     * @covers \LupusCoding\Webhooks\Teams\MessageAction\OpenUri
     */
    public function testCanCreateAndAddPotentialAction(): void
    {
        $card = new MessageCard();
        $card->addPotentialAction(
            new OpenUri()
        );
        $this->assertInstanceOf(OpenUri::class, $card->getPotentialActions()[0]);
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\MessageCard
     */
    public function testCanSerializeMinimalCard(): void
    {
        $card = new MessageCard();
        $this->assertEquals(
            json_encode([
                '@type' => 'MessageCard',
                '@context' => AbstractCard::MESSAGE_CONTEXT,
                'themeColor' => ThemeColor::INFO,
                'summary' => '',
            ]),
            json_encode($card)
        );
        // uncomment debug output if required:
//        print_r(__METHOD__ . ' JSON: ' . json_encode($card->jsonSerialize()));
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\MessageCard
     * @covers \LupusCoding\Webhooks\Teams\MessageSection
     * @covers \LupusCoding\Webhooks\Teams\MessageAction\OpenUri
     */
    public function testCanSerializeFullCard(): void
    {
        $card = new MessageCard();
        $card->setThemeColor(ThemeColor::DEBUG)
            ->setSummary('This is a summary');
        $card->addSection($this->createMessageSection());
        $potentialAction = new OpenUri();
        $potentialAction->setName('Click me')
            ->addTarget('http://lupuscoding.de');
        $card->addPotentialAction($potentialAction);

        $assertData = $this->getSerializationAssertionData();

        $this->assertEquals(
            json_encode($assertData),
            json_encode($card)
        );
        // uncomment debug output if required:
//        print_r(__METHOD__ . ' JSON: ' . json_encode($card->jsonSerialize()));
    }

    private function getSerializationAssertionData(): array
    {
        return [
            '@type' => 'MessageCard',
            '@context' => AbstractCard::MESSAGE_CONTEXT,
            'themeColor' => ThemeColor::DEBUG,
            'summary' => 'This is a summary',
            'sections' => [
                [
                    'activityTitle' => 'Test activity',
                    'activitySubtitle' => 'This is a unit test',
                    'activityImage' => 'activity.png',
                    'facts' => [
                        [
                            'name' => 'Test fact',
                            'value' => 'This is a fact',
                        ],
                    ],
                    'markdown' => false,
                ],
            ],
            'potentialAction' => [
                [
                    '@type' => 'OpenUri',
                    'name' => 'Click me',
                    'targets' => [
                        [
                            'os' => 'default',
                            'uri' => 'http://lupuscoding.de',
                        ],
                    ],
                ],
            ],
        ];
    }

    /**
     * @covers \LupusCoding\Webhooks\Teams\MessageCard
     * @covers \LupusCoding\Webhooks\Teams\MessageSection
     * @covers \LupusCoding\Webhooks\Teams\MessageAction\OpenUri
     */
    public function testSendMessageCard(): void
    {
        $potentialAction = new OpenUri();
        $potentialAction->setName('Click me')
            ->addTarget('http://lupuscoding.de');

        $card = new MessageCard();
        $card->setThemeColor(ThemeColor::SUCCESS)
            ->setSummary('PHPUnit test')
            ->addSection($this->createMessageSection())
            ->addPotentialAction($potentialAction);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_URL, self::WEBHOOK_URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($card));

        $headers = array();
        $headers[] = 'Content-Type:application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $success = (curl_errno($ch) === 0);
        if (!$success) {
            throw new Exception("Error: " . curl_error($ch));
        }
        // uncomment debug output if required:
//        print_r(__METHOD__ . ' Result: ' . $result);

        curl_close($ch);
        $this->assertTrue($success);
    }
}
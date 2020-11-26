<?php

namespace unit;

use Heartbreaker\Controllers\GameRules;
use Heartbreaker\Entities\Card;
use Heartbreaker\Entities\Player;
use PHPUnit\Framework\TestCase;

/**
 * Class GameRulesTest
 * @package unit
 * @group gamerules
 */
class GameRulesTest extends TestCase
{
    /**
     * @group cp
     */
    public function testCardPoints()
    {
        $card1 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();
        $card1->method('getSuit')
            ->willReturn('♥');

        $card2 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();
        $card2->method('getSuit')
            ->willReturn('♣');
        $card2->method('getName')
            ->willReturn('J');

        $card3 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();
        $card3->method('getSuit')
            ->willReturn('♠');
        $card3->method('getName')
            ->willReturn('Q');

        $card4 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();
        $card4->method('getSuit')
            ->willReturn('♠');
        $card4->method('getName')
            ->willReturn('A');

        $this->assertEquals(1, GameRules::cardPoints($card1));
        $this->assertEquals(2, GameRules::cardPoints($card2));
        $this->assertEquals(5, GameRules::cardPoints($card3));
        $this->assertEquals(0, GameRules::cardPoints($card4));
    }

    public function testCurrentSuit()
    {
        $card1 = $this->getMockBuilder(Card::class)
            ->disableOriginalConstructor()
            ->getMock();
        $card1->method('getSuit')
            ->willReturn('♥');

        $this->assertEquals('♥', GameRules::currentSuit([$card1]));
    }

    public function testCheckIfGameOver()
    {
        $player1 = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $player1->method('getPoints')
            ->willReturn(49);
        $this->assertFalse(GameRules::checkIfGameOver($player1));

        $player2 = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $player2->method('getPoints')
            ->willReturn(50);
        $this->assertTrue(GameRules::checkIfGameOver($player2));

        $player3 = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $player3->method('getPoints')
            ->willReturn(51);
        $this->assertTrue(GameRules::checkIfGameOver($player3));
    }
}

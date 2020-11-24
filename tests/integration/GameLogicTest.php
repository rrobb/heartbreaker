<?php
declare(strict_types = 1);

use Heartbreaker\GameLogic;
use PHPUnit\Framework\TestCase;

class GameLogicTest extends TestCase
{

    public function testShuffleDeck()
    {
    }

    /**
     * @group play
     */
    public function testPlayGame()
    {
        $result = (new GameLogic())->playGame();
    }

    public function testGetRoundPoints()
    {
    }

    public function testSetupGameWorld()
    {
    }

    public function testGetLoserOfRound()
    {
    }

    public function testCheckIfGameOver()
    {
    }

    public function testPickWorstCardPlayed()
    {
    }

    public function testRandomizeSeatOrder()
    {
    }

    public function testDealCards()
    {
    }

    public function testContinueWithNextPlayer()
    {
    }

    public function testPlayRound()
    {
    }
}

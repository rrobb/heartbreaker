<?php
declare(strict_types = 1);

namespace Tests\Integration;

use Heartbreaker\Factories\GameLogicFactory;
use PHPUnit\Framework\TestCase;
use Sabre\Event\Emitter;

class GameLogicTest extends TestCase
{
    /**
     * Asserts that the game loop returns a Player object with a score of 50 or higher
     * @group play
     */
    public function testGameLoop()
    {
        $gameLogic = GameLogicFactory::createGameLogic(new Emitter());
        $loser = $gameLogic->gameLoop();
        $this->assertGreaterThanOrEqual(50, $loser->getPoints());
    }
}

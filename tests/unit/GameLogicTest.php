<?php

namespace Tests\Unit;

use Heartbreaker\Controllers\GameLogic;
use Heartbreaker\Entities\Game;
use Heartbreaker\Entities\Player;
use Heartbreaker\Handlers\HandlerInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class GameLogicTest
 * @package Tests\Unit
 */
class GameLogicTest extends TestCase
{
    /**
     * @group gl
     */
    public function testGameLoop()
    {
        $handler = $this->getMockBuilder(HandlerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $loser = $this->getMockBuilder(Player::class)
            ->disableOriginalConstructor()
            ->getMock();
        $game = $this->getMockBuilder(Game::class)
            ->disableOriginalConstructor()
            ->getMock();
        $game->method('isGameOver')
            ->willReturn(true);
        $game->method('getLoser')
            ->willReturn($loser);
        $gameLogic = new GameLogic($handler, $game);
        $result = $gameLogic->gameLoop();

        $this->assertInstanceOf(Player::class, $result);
    }
}

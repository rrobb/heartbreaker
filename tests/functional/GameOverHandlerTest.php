<?php

namespace Handlers;

use Heartbreaker\Entities\Game;
use Heartbreaker\Entities\Hand;
use Heartbreaker\Entities\Player;
use Heartbreaker\Handlers\GameOverHandler;
use PHPUnit\Framework\TestCase;
use Sabre\Event\Emitter;

/**
 * Class GameOverHandlerTest
 * @package Handlers
 * @group gameover
 */
class GameOverHandlerTest extends TestCase
{
    public function testHandle()
    {
        $emitter = new Emitter();
        $game = new Game();
        $game->setLoser(
            new Player(
                'Jan',
                new Hand(),
                $emitter
            )
        );
        $game->getLoser()->addPoints(49);

        $handler = new GameOverHandler($emitter);
        $handler->handle($game);
        $this->assertFalse($game->isGameOver());

        $game->getLoser()->addPoints(1);
        $handler->handle($game);

        $this->assertTrue($game->isGameOver());
    }
}

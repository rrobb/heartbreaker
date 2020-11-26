<?php

namespace Handlers;

use Heartbreaker\Entities\Card;
use Heartbreaker\Entities\Game;
use Heartbreaker\Handlers\NewRoundHandler;
use PHPUnit\Framework\TestCase;
use Sabre\Event\Emitter;

class NewRoundHandlerTest extends TestCase
{
    public function testHandle()
    {
        $emitter = new Emitter();
        $game = new Game();
        $game->setRounds(1);
        $game->setCardsPlayed(
            [
                new Card(
                    'a',
                    ['value' => 1, 'name' => 'b']
                )
            ]
        );

        $handler = new NewRoundHandler($emitter);
        $handler->handle($game);
        $this->assertEquals(2, $game->getRounds());
        $this->assertCount(0, $game->getCardsPlayed());
    }
}

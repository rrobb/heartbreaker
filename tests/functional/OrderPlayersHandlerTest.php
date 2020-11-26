<?php

namespace functional;

use Heartbreaker\Entities\Game;
use Heartbreaker\Entities\Hand;
use Heartbreaker\Entities\Player;
use Heartbreaker\Handlers\OrderPlayersHandler;
use PHPUnit\Framework\TestCase;
use Sabre\Event\Emitter;

class OrderPlayersHandlerTest extends TestCase
{
    public function testRandomizeSeatOrder()
    {
        $emitter = new Emitter();
        $player1 = new Player('Jan', new Hand(), $emitter);
        $player2 = new Player('Piet', new Hand(), $emitter);
        $player3 = new Player('Klaas', new Hand(), $emitter);
        $player4 = new Player('Kees', new Hand(), $emitter);
        $players = [
            $player1,
            $player2,
            $player3,
            $player4,
        ];
        $game = new Game();
        $game->setPlayers($players);

        $handler = new OrderPlayersHandler($emitter);
        $result = $handler->randomizeSeatOrder($game->getPlayers());
        $this->assertNotEquals(
            implode('', $players),
            implode('', $result)
        );
    }
    public function testContinueWithNextPlayer()
    {
        $emitter = new Emitter();
        $player1 = new Player('Jan', new Hand(), $emitter);
        $player2 = new Player('Piet', new Hand(), $emitter);
        $player3 = new Player('Klaas', new Hand(), $emitter);
        $player4 = new Player('Kees', new Hand(), $emitter);
        $players = [
            $player1,
            $player2,
            $player3,
            $player4,
        ];
        $game = new Game();
        $game->setPlayers($players);

        $handler = new OrderPlayersHandler($emitter);
        $result = $handler->continueWithNextPlayer($game->getPlayers());
        $this->assertEquals(
            implode(
                '',
                [
                    $player2,
                    $player3,
                    $player4,
                    $player1,
                ]
            ),
            implode('', $result),
        );
    }
}

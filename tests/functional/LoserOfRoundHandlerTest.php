<?php

namespace functional;

use Heartbreaker\Entities\Card;
use Heartbreaker\Entities\Hand;
use Heartbreaker\Entities\Player;
use Heartbreaker\Handlers\LoserOfRoundHandler;
use PHPUnit\Framework\TestCase;
use Sabre\Event\Emitter;

class LoserOfRoundHandlerTest extends TestCase
{
    public function testGetLoserOfRound()
    {
        $emitter = new Emitter();
        $loser = new Player(
            'Jan',
            new Hand(),
            $emitter
        );
        $winner = new Player(
            'Piet',
            new Hand(),
            $emitter
        );
        $losingCard = new Card('a', ['value' => 10, 'name' => 'b']);
        $winningCard = new Card('a', ['value' => 1, 'name' => 'b']);
        $handler = new LoserOfRoundHandler($emitter);
        $result = $handler->getLoserOfRound(
            [$loser, $winner],
            [$losingCard, $winningCard]
        );

        $this->assertSame($loser, $result);
    }

    public function testGetRoundPoints()
    {
        $emitter = new Emitter();
        $losingCard = new Card('♥', ['value' => 10, 'name' => 'b']);
        $winningCard = new Card('♥', ['value' => 1, 'name' => 'b']);
        $handler = new LoserOfRoundHandler($emitter);
        $result = $handler->getRoundPoints(
            [$losingCard, $winningCard]
        );

        $this->assertEquals(2, $result);
    }
}

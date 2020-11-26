<?php

namespace functional;

use Heartbreaker\Entities\Game;
use Heartbreaker\Entities\Hand;
use Heartbreaker\Entities\Player;
use Heartbreaker\Factories\PlayerFactory;
use Heartbreaker\Handlers\PlayRoundHandler;
use Heartbreaker\Handlers\ShuffleCardsHandler;
use PHPUnit\Framework\TestCase;
use Sabre\Event\Emitter;

class PlayRoundHandlerTest extends TestCase
{
    public function testPlayRound()
    {
        $emitter = new Emitter();
        $handler = new PlayRoundHandler($emitter);
        $shuffle = new ShuffleCardsHandler($emitter);
        $players = $shuffle->shuffleAndDealCards(PlayerFactory::addPlayers($emitter));
        $result = $handler->playRound(
            1,
            $players,
            []
        );

        $this->assertCount(4, $result);
    }
}

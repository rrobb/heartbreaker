<?php

namespace functional;

use Heartbreaker\Entities\Hand;
use Heartbreaker\Factories\CardFactory;
use Heartbreaker\Factories\PlayerFactory;
use Heartbreaker\Handlers\PlayRoundHandler;
use Heartbreaker\Handlers\ShuffleCardsHandler;
use PHPUnit\Framework\TestCase;
use Sabre\Event\Emitter;

use function Webmozart\Assert\Tests\StaticAnalysis\length;

class ShuffleCardsHandlerTest extends TestCase
{

    public function testShuffleAndDealCards()
    {
        $emitter = new Emitter();
        $handler = new ShuffleCardsHandler($emitter);
        $players = $handler->shuffleAndDealCards(
            PlayerFactory::addPlayers($emitter)
        );
        $hand = new Hand();
        $hand->setCards(CardFactory::createCardDeck());
        $inOrderString = (string)$hand;
        foreach ($players as $player) {
            $s = (string)$player->getHand();
            $this->assertStringNotContainsString($s, $inOrderString);
        }
    }
}

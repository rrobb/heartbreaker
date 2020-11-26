<?php
declare(strict_types=1);

namespace Heartbreaker\Handlers;

use Heartbreaker\Entities\Game;
use Heartbreaker\Entities\Player;
use Heartbreaker\Factories\CardFactory;
use Heartbreaker\Controllers\GameRules;

/**
 * Class ShuffleCardsHandler
 * @package Heartbreaker\Handlers
 */
class ShuffleCardsHandler extends AbstractHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Game $game): ?Game
    {
        if ($game->getRounds() === 1) {
            $game->setPlayers(
                $this->shuffleAndDealCards(
                    $game->getPlayers()
                )
            );
            $this->emit('startGame', [$game->getPlayers()]);
            return parent::handle($game);
        }
        if (($game->getRounds() - 1) % GameRules::MAX_CARDS_IN_HAND === 0) {
            $game->setPlayers(
                $this->shuffleAndDealCards(
                    $game->getPlayers()
                )
            );
            $this->emit('reshuffle', [$game->getPlayers()]);
        }
        return parent::handle($game);
    }

    /**
     * Shuffle the cards and distribute them round-robin among the players.
     * @param Player[] $players
     * @return Player[]
     */
    public function shuffleAndDealCards(array $players): array
    {
        $deck = CardFactory::createCardDeck();
        shuffle($deck);
        $count = count($players);
        foreach ($deck as $i => $card) {
            $player = $players[$i % $count];
            $player->getHand()->addCard($card);
        }

        return $players;
    }
}
<?php
declare(strict_types=1);

namespace Heartbreaker\Handlers;

use Heartbreaker\Entities\Card;
use Heartbreaker\Entities\Game;
use Heartbreaker\Entities\Player;
use Heartbreaker\Controllers\GameRules;

/**
 * Class LoserOfRoundHandler
 * @package Heartbreaker\Handlers
 */
class LoserOfRoundHandler extends AbstractHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Game $game): ?Game
    {
        $game->setLoser(
            $this->getLoserOfRound(
                $game->getPlayers(),
                $game->getCardsPlayed()
            )
        );
        $game->getLoser()->addPoints(
            $this->getRoundPoints(
                $game->getCardsPlayed()
            )
        );
        $this->emit('loserTotalPoints', [$game->getLoser()]);

        return parent::handle($game);
    }

    /**
     * @param array $players
     * @param array $cardsPlayed
     * @return Player
     */
    public function getLoserOfRound(
        array $players,
        array $cardsPlayed
    ): Player {
        $currentSuit = GameRules::currentSuit($cardsPlayed);
        $losingCard = $cardsPlayed[0];
        $loser = $players[0];
        foreach ($cardsPlayed as $index => $card) {
            /** @var Card $card */
            if (
                $card->getSuit() === $currentSuit &&
                $card->getValue() > $losingCard->getValue()
            ) {
                $losingCard = $card;
                $loser = $players[$index];
            }
        }
        $this->emit('loserOfRound', [$loser, $losingCard]);

        return $loser;
    }

    /**
     * Add up and return all points in the current round of play.
     * @param array $cardsPlayed
     * @return int
     */
    public function getRoundPoints(array $cardsPlayed): int
    {
        $points = 0;
        foreach ($cardsPlayed as $playerOrder => $card) {
            $points += GameRules::cardPoints($card);
        }
        $this->emit('loserAddPoints', [$points]);

        return $points;
    }
}
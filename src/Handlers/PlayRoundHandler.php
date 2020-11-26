<?php
declare(strict_types=1);

namespace Heartbreaker\Handlers;

use Heartbreaker\Entities\Game;

/**
 * Class PlayRoundHandler
 * @package Heartbreaker\Handlers
 */
class PlayRoundHandler extends AbstractHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Game $game): ?Game
    {
        $game->setCardsPlayed(
            $this->playRound(
                $game->getRounds(),
                $game->getPlayers(),
                $game->getCardsPlayed() ?? []
            )
        );

        return parent::handle($game);
    }

    /**
     * @param int $rounds
     * @param array $players
     * @param array $cardsPlayed
     * @return array
     */
    public function playRound(
        int $rounds,
        array $players,
        array $cardsPlayed
    ) {
        $this->emit('newRound', [$rounds, $players[0]]);
        foreach ($players as $player) {
            $cardsPlayed[] = $player->playTurn($cardsPlayed ?? []);
        }

        return $cardsPlayed ?? [];
    }
}
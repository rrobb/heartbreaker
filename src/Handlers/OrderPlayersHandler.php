<?php
declare(strict_types=1);

namespace Heartbreaker\Handlers;

use Heartbreaker\Entities\Game;
use Heartbreaker\Entities\Player;
use Heartbreaker\Factories\PlayerFactory;

/**
 * Class OrderPlayersHandler
 * @package Heartbreaker\Handlers
 */
class OrderPlayersHandler extends AbstractHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Game $game): ?Game
    {
        if ($game->getRounds() === 1) {
            $game->setPlayers(
                $this->randomizeSeatOrder(
                    PlayerFactory::addPlayers($this->emitter)
                )
            );
        } else {
            $game->setPlayers(
                $this->continueWithNextPlayer(
                    $game->getPlayers()
                )
            );

        }

        return parent::handle($game);
    }

    /**
     * Here we set the player order, randomized for each new game.
     * @param Player[] $players
     * @return array
     */
    public function randomizeSeatOrder(array $players): array
    {
        shuffle($players);
        return $players;
    }

    /**
     * Business rule "the next rounds starts with the next player"
     * After a round is finished we move the starting player to the end of the line.
     * @param array $players
     * @return array
     */
    public function continueWithNextPlayer(array $players): array
    {
        $played = array_shift($players);
        array_push($players, $played);

        return $players;
    }
}
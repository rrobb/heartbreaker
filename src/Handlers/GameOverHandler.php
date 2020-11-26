<?php
declare(strict_types=1);

namespace Heartbreaker\Handlers;

use Heartbreaker\Entities\Game;
use Heartbreaker\Controllers\GameRules;

/**
 * Class GameOverHandler
 * @package Heartbreaker\Handlers
 */
class GameOverHandler extends AbstractHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Game $game): ?Game
    {
        if ($game->getLoser()->getPoints() >= GameRules::LOSING_SCORE) {
            $game->gameOver();
            $this->emit('gameOver', [$game->getLoser(), $game->getPlayers()]);
        }

        return parent::handle($game);
    }
}
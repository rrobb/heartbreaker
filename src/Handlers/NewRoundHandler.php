<?php
declare(strict_types=1);

namespace Heartbreaker\Handlers;

use Heartbreaker\Entities\Game;

/**
 * Class NewRoundHandler
 * @package Heartbreaker\Handlers
 */
class NewRoundHandler extends AbstractHandler
{
    /**
     * @inheritDoc
     */
    public function handle(Game $game): ?Game
    {
        $game->newRound();
        $game->setCardsPlayed([]);
        return parent::handle($game);
    }
}
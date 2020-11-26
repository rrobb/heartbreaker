<?php
declare(strict_types=1);

namespace Heartbreaker\Controllers;

use Heartbreaker\Entities\Game;
use Heartbreaker\Entities\Player;
use Heartbreaker\Handlers\HandlerInterface;
use Sabre\Event\Emitter;

/**
 * Class GameLogic
 * @package Heartbreaker
 */
class GameLogic extends Emitter
{
    public const NUMBER_OF_PLAYERS = 4;
    public const FIRST_PLAYER = 0;

    /**
     * @var HandlerInterface
     */
    private HandlerInterface $playHandler;

    /**
     * @var Game
     */
    private Game $game;

    /**
     * GameLogic constructor.
     * @param HandlerInterface $handler
     * @param Game $game
     */
    public function __construct(
        HandlerInterface $handler,
        Game $game
    ) {
        $this->playHandler = $handler;
        $this->game = $game;
    }

    /**
     * The main game loop
     * @return ?Player
     */
    public function gameLoop(): ?Player
    {
        $gameOver = false;
        while (!$gameOver) {
            $playHandler = $this->playHandler;
            $playHandler->handle($this->game);
            $gameOver = $this->game->isGameOver();
        }

        return $this->game->getLoser() ?? null;
    }
}
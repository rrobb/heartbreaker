<?php
declare(strict_types = 1);

namespace Heartbreaker\Factories;

use Heartbreaker\Controllers\GameLogic;
use Heartbreaker\Entities\Game;
use Heartbreaker\Handlers\GameOverHandler;
use Heartbreaker\Handlers\LoserOfRoundHandler;
use Heartbreaker\Handlers\NewRoundHandler;
use Heartbreaker\Handlers\OrderPlayersHandler;
use Heartbreaker\Handlers\PlayRoundHandler;
use Heartbreaker\Handlers\ShuffleCardsHandler;
use Heartbreaker\Subscribers\ReportingSubscriber;
use Sabre\Event\Emitter;

/**
 * Class GameLogicFactory
 * @package Heartbreaker\Factories
 */
class GameLogicFactory
{
    /**
     * @param Emitter $emitter
     * @return GameLogic
     */
    public static function createGameLogic(Emitter $emitter)
    {
        $playHandler = new NewRoundHandler($emitter);
        $playHandler
            ->setNext(new OrderPlayersHandler($emitter))
            ->setNext(new ShuffleCardsHandler($emitter))
            ->setNext(new PlayRoundHandler($emitter))
            ->setNext(new LoserOfRoundHandler($emitter))
            ->setNext(new GameOverHandler($emitter));
        new ReportingSubscriber($emitter);

        return new GameLogic($playHandler, new Game());
    }
}
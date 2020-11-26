<?php
declare(strict_types = 1);

namespace Heartbreaker\Factories;

use Heartbreaker\Entities\Hand;
use Heartbreaker\Entities\Player;
use Sabre\Event\Emitter;

/**
 * Class PlayerFactory
 * @package Heartbreaker\Factories
 */
class PlayerFactory
{
    /**
     * @param Emitter $emitter
     * @return Player[]
     */
    public static function addPlayers(Emitter $emitter): array
    {
        return [
            new Player('Robert Plant', new Hand(), $emitter),
            new Player('Jimmy Page', new Hand(), $emitter),
            new Player('John Bonham', new Hand(), $emitter),
            new Player('John Paul Jones', new Hand(), $emitter),
        ];
    }
}
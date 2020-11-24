<?php
declare(strict_types = 1);

namespace Heartbreaker\Factories;

use Heartbreaker\Entities\Hand;
use Heartbreaker\Entities\Player;

class PlayerFactory
{
    /**
     * @return Player[]
     */
    public static function addPlayers(): array
    {
        return [
            new Player('Robert Plant', new Hand()),
            new Player('Jimmy Page', new Hand()),
            new Player('John Bonham', new Hand()),
            new Player('John Paul Jones', new Hand()),
        ];
    }
}
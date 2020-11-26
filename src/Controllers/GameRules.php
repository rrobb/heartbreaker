<?php
declare(strict_types = 1);

namespace Heartbreaker\Controllers;

use Heartbreaker\Entities\Card;
use Heartbreaker\Entities\Player;

class GameRules
{
    public const FIRST_PLAYER = 0;
    public const LOSING_SCORE = 50;
    public const MAX_CARDS_IN_HAND = 8;

    /**
     * Return the number of points the given card is worth according to the business rules.
     * @param Card $card
     * @return int
     */
    public static function cardPoints(Card $card): int
    {
        if ($card->getSuit() === '♥') {
            return 1;
        }
        if (
            $card->getSuit() === '♣' &&
            $card->getName() === 'J'
        ) {
            return 2;
        }
        if (
            $card->getSuit() === '♠' &&
            $card->getName() === 'Q'
        ) {
            return 5;
        }

        return 0;
    }

    /**
     * Business rule: The first card of the round determines the current suit to be played.
     * @param Card[] $cardsPlayed
     * @return string
     */
    public static function currentSuit(array $cardsPlayed): string
    {
        return $cardsPlayed[0]->getSuit();
    }

    /**
     * If the most recent losing player exceeds the maximum allowed amount of points, they lose and the game is over.
     * @param Player $player
     * @return bool
     */
    public static function checkIfGameOver(Player $player): bool
    {
        return $player->getPoints() >= self::LOSING_SCORE;
    }
}
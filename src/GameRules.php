<?php
declare(strict_types = 1);

namespace Heartbreaker;

use Heartbreaker\Entities\Card;

class GameRules
{
    public const FIRST_PLAYER = 0;
    public const LOSING_SCORE = 50;

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
     * @param array $cardsPlayed
     * @return mixed
     */
    public static function currentSuit(array $cardsPlayed): string
    {
        return ($cardsPlayed[0])->getSuit();
    }

    /**
     * Returns the losing score.
     * @return int
     */
    public static function losingScore()
    {
        return self::LOSING_SCORE;
    }
}
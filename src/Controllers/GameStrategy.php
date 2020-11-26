<?php
declare(strict_types=1);

namespace Heartbreaker\Controllers;

use Heartbreaker\Entities\Card;

class GameStrategy
{
    /**
     * Returns a card to play, picked from the current hand presented.
     * We will either:
     * - return a random card if it's the first turn in the first round
     * - return an on suit card if available, trying to beat what's already on the table
     * - return a random card if there are no on-suit cards available
     * @param array $hand
     * @param array $cardsPlayed
     * @return Card
     */
    public static function identifyCardToPlay(
        array $hand,
        array $cardsPlayed
    ): Card {
        if (count($cardsPlayed) === 0) {
            return self::pickRandomCard($hand);
        }

        return self::pickOptimalCard($hand, $cardsPlayed) ?? self::pickRandomCard($hand);
    }

    /**
     * Returns a random card and removes it from the player's hand
     * @param array $hand
     * @return Card
     */
    public static function pickRandomCard(array $hand): Card
    {
        $index = 1;
        $count = count($hand);
        if ($count > $index) {
            $index = rand($index, $count);
        }

        return $hand[$index - 1];
    }

    /**
     * @param array $hand
     * @param array $cardsPlayed
     * @return Card|null
     */
    public static function pickOptimalCard(array $hand, array $cardsPlayed): ?Card
    {
        $weakestCard = self::identifyWeakestCardPlayed($cardsPlayed);
        $currentSuit = GameRules::currentSuit($cardsPlayed);
        $cardToPlay = null;
        foreach ($hand as $card) {
            if ($card->getSuit() !== $currentSuit) {
                continue;
            }
            if ($cardToPlay === null) {
                $cardToPlay = $card;
                continue;
            }
            if ($cardToPlay->getValue() > $weakestCard->getValue()) {
                // We want to go lower, even if it's still higher than the weakest card because
                // the next player may be weaker still
                if ($card->getValue() < $weakestCard->getValue()) {
                    $cardToPlay = $card;
                }
                continue;
            }
            if ($card->getValue() < $weakestCard->getValue()) {
                // We want to go higher without surpassing the weakest card as low value cards are safer to hold on to
                if ($card->getValue() > $cardToPlay->getValue()) {
                    $cardToPlay = $card;
                }
                continue;
            }
        }

        return $cardToPlay;
    }

    /**
     * The 'weakest card' played is the card that has the highest value of all cards currently played on-suit.
     * This is the card the current player has to beat to not lose the round.
     * @param array $cardsPlayed
     * @return Card
     */
    public static function identifyWeakestCardPlayed(array $cardsPlayed): Card
    {
        $currentSuit = GameRules::currentSuit($cardsPlayed);
        $weakestCard = $cardsPlayed[0];
        foreach ($cardsPlayed as $card) {
            if ($card->getSuit() !== $currentSuit) {
                continue;
            }
            if ($card->getValue() < $weakestCard->getValue()) {
                continue;
            }
            $weakestCard = $card;
        }

        return $weakestCard;
    }
}
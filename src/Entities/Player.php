<?php

declare(strict_types=1);

namespace Heartbreaker\Entities;

use Exception;
use Heartbreaker\GameLogic;
use Heartbreaker\GameRules;
use http\Exception\RuntimeException;

class Player
{
    private string $name;

    private int $points = 0;

    /**
     * @var Hand
     */
    private Hand $hand;

    /**
     * Player constructor.
     * @param string $name
     * @param Hand $hand
     */
    public function __construct(string $name, Hand $hand)
    {
        $this->name = $name;
        $this->hand = $hand;
    }

    /**
     * Add a new card to the player's hand.
     * @param Card $card
     */
    public function addToHand(Card $card)
    {
        $this->hand[] = $card;
    }

    /**
     * Play a card and remove it from the player's hand.
     * @param array $cardsPlayed
     * @return Card
     */
    public function playTurn(array $cardsPlayed): Card
    {
        if (count($cardsPlayed) === 0) {
            $card = $this->pickRandomCard();
            echo PHP_EOL . $this . ' plays: ' . $card;

            return $card;
        }
        if (!$this->hasCurrentSuit($cardsPlayed)) {
            $card = $this->pickRandomCard();
            echo PHP_EOL . $this . ' plays: ' . $card;

            return $card;
        }

        $card = $this->pickBestCard($cardsPlayed);
        echo PHP_EOL . $this . ' plays: ' . $card;

        return $card;
    }

    /**
     * Returns whether the player has cards of the current suit.
     * @param array $cardsPlayed
     * @return bool
     */
    public function hasCurrentSuit(array $cardsPlayed)
    {
        $currentSuit = GameRules::currentSuit($cardsPlayed);
        foreach ($this->hand as $card) {
            if ($card->getSuit() === $currentSuit) {
                return true;
            }
        }
        return false;
    }

    /**
     * Returns a random card and removes it from the player's hand
     * @return Card
     */
    public function pickRandomCard(): Card
    {
        try {
            $index = 1;
            $count = count($this->getHand());
            if ($count > 1) {
                $index = random_int(1, $count);
            }
        } catch (Exception $e) {
            throw new RuntimeException('Not enough entropy, we cannot shuffle fairly');
        }

            return $this->removeFromHandAndPlay($index - 1);
    }

    /**
     * Removes a card form the payer's hand and returns it.
     * @param int $key
     * @return Card
     */
    private function removeFromHandAndPlay(int $key): Card
    {
        $card = $this->hand[$key];
        unset($this->hand[$key]);

        return $card;
    }

    private function pickBestCard(array $cardsPlayed)
    {
        $toBeatCard = GameLogic::pickWorstCardPlayed($cardsPlayed);
        $value = $toBeatCard->getValue();
        $validCardsInHand = $this->getValidCardsInHand($toBeatCard);
        if (count($validCardsInHand) === 0) {
            return $this->pickRandomCard();
        }
        $index = array_search($this->getBestCard($validCardsInHand, $value), $this->hand);

        return $this->removeFromHandAndPlay($index);
    }

    /**
     * Returns all cards in the player's hand that match the current suit.
     * @param Card $toBeatCard
     * @return array
     */
    public function getValidCardsInHand(Card $toBeatCard): array
    {
        $suit = $toBeatCard->getSuit();

        return array_filter(
            $this->hand,
            function (Card $card) use ($suit) {
                if ($card->getSuit() === $suit) {
                    return true;
                }
            }
        );
    }

    public function getBestCard(array $validCardsInHand, $value)
    {
        usort(
            $validCardsInHand,
            fn($a, $b) => $a->getValue() <=> $b->getValue()
        );

        return $validCardsInHand[0];
    }

    /**
     * Add all points from the last round of play which the current player lost.
     * @param int $points
     */
    public function addPoints(int $points): void
    {
        $this->points += $points;
    }

    /**
     * Returns the current player's points.
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Returns the current player's hand.
     * @return Hand
     */
    public function getHand(): Hand
    {
        return $this->hand;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
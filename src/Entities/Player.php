<?php
declare(strict_types=1);

namespace Heartbreaker\Entities;

use Heartbreaker\Controllers\GameStrategy;
use Sabre\Event\Emitter;

/**
 * Class Player
 * @package Heartbreaker\Entities
 */
class Player
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $points = 0;

    /**
     * @var Hand
     */
    private Hand $hand;

    /**
     * @var Emitter
     */
    private Emitter $emitter;

    /**
     * Player constructor.
     * @param string $name
     * @param Hand $hand
     * @param Emitter $emitter
     */
    public function __construct(
        string $name,
        Hand $hand,
        Emitter $emitter
    ) {
        $this->name = $name;
        $this->hand = $hand;
        $this->emitter = $emitter;
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
        $cardToPlay = GameStrategy::identifyCardToPlay(
            $this->getHand()->getCards(),
            $cardsPlayed
        );
        $this->emitter->emit('playTurn', [$this, $cardToPlay]);
        $this->getHand()->removeCard($cardToPlay);

        return $cardToPlay;
    }

    /**
     * Add all points from the last round of play which the current player lost.
     * @param int $points
     */
    public function addPoints(int $points): void
    {
        $this->points += $points;
        $this->emitter->emit('player.addPoints', [$this, $points]);
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

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
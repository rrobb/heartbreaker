<?php
declare(strict_types = 1);

namespace Heartbreaker\Factories;

use Heartbreaker\Entities\Card;

/**
 * Class CardFactory
 * @package Heartbreaker\Factories
 * @codeCoverageIgnore
 */
class CardFactory
{
    public const SUITS = [
        '♥',
        '♠',
        '♦',
        '♣',
    ];
    public const VALUES = [
        ['name' => '7', 'value' => 7],
        ['name' => '8', 'value' => 8],
        ['name' => '9', 'value' => 9],
        ['name' => '10', 'value' => 10],
        ['name' => 'J', 'value' => 11],
        ['name' => 'Q', 'value' => 12],
        ['name' => 'K', 'value' => 13],
        ['name' => 'A', 'value' => 14],
    ];

    /**
     * Returns a complete, sorted deck of cards
     * @return Card[]
     */
    public static function createCardDeck(): array
    {
        $stack = [];
        foreach (self::SUITS as $suit) {
            $values = self::VALUES;
            while ($values) {
                array_push(
                    $stack,
                    new Card(
                        $suit,
                        array_pop($values)
                    )
                );
            }
        }

        return $stack;
    }

    /**
     * Shuffles the provided deck of cards
     * @param Card[] $deck
     * @return Card[]
     */
    public function shuffleDeck(array $deck): array
    {
        shuffle($deck);

        return $deck;
    }
}
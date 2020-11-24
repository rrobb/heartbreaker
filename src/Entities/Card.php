<?php
declare(strict_types = 1);

namespace Heartbreaker\Entities;

class Card
{
    private string $suit;
    private int $value;
    private string $name;

    /**
     * Card constructor.
     * @param string $suit
     * @param array $value
     */
    public function __construct(string $suit, array $value)
    {
        $this->suit = $suit;
        $this->value = $value['value'];
        $this->name = $value['name'];
    }

    /**
     * Returns the card's suit.
     * @return string
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Returns the card's value.
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Returns the card's name.
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Returns a string representation of the card.
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s%s', $this->getSuit(), $this->getName());
    }
}
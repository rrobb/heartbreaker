<?php


namespace Heartbreaker\Entities;


use ArrayAccess;
use Countable;

class Hand implements ArrayAccess, Countable
{
    private array $cards;

    public function setCards(array $cards)
    {
        $this->cards = array_values($cards);
    }

    public function getCards()
    {
        return $this->cards;
    }

    public function addCard(Card $card)
    {
        $this->cards[] = $card;
    }

    public function __toString()
    {
        return implode(' ', $this->cards);
    }

    public function __toArray()
    {
        return $this->cards;
    }

    public function offsetExists($offset)
    {
        return isset($this->cards[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->cards[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->cards[$offset] = $value;
    }

    /**
     * Unset the offset and reorder the cards so there are no gaps.
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->cards[$offset]);
        $this->cards = array_values($this->cards);
    }

    public function count()
    {
        return count($this->cards);
    }
}
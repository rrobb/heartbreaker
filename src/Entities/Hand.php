<?php
declare(strict_types=1);

namespace Heartbreaker\Entities;

use ArrayAccess;
use Countable;
use Iterator;

/**
 * Class Hand
 * @package Heartbreaker\Entities
 */
class Hand implements ArrayAccess, Countable, Iterator
{
    /**
     * @var array
     */
    private array $cards;

    /**
     * @param array $cards
     */
    public function setCards(array $cards): void
    {
        $this->cards = array_values($cards);
    }

    /**
     * @return array
     */
    public function getCards(): array
    {
        return $this->cards;
    }

    /**
     * Adds a card to the hand
     * @param Card $card
     */
    public function addCard(Card $card): void
    {
        $this->cards[] = $card;
    }

    /**
     * Removes a card from the hand
     * @param Card $card
     */
    public function removeCard(Card $card): void
    {
        $pos = array_search($card, $this->cards);
        $this->offsetUnset($pos);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return implode(' ', $this->cards);
    }

    /**
     * @return array
     */
    public function __toArray(): array
    {
        return $this->cards;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset): bool
    {
        return isset($this->cards[$offset]);
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->cards[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
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
        $cards = $this->cards;
        unset($cards[$offset]);
        $this->cards = array_values($cards);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->cards);
    }

    /**
     * @return mixed
     */
    public function current()
    {
        return current($this->cards);
    }

    /**
     * @return mixed|void
     */
    public function next()
    {
        return next($this->cards);
    }

    /**
     * @return bool|float|int|string|null
     */
    public function key()
    {
        return key($this->cards);
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        $key = key($this->cards);

        return ($key !== NULL && $key !== FALSE);
    }

    /**
     *
     */
    public function rewind(): void
    {
        reset($this->cards);
    }
}
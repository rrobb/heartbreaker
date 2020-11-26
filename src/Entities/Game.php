<?php
declare(strict_types=1);

namespace Heartbreaker\Entities;

/**
 * Class Game
 * @package Heartbreaker\Entities
 */
class Game
{
    /**
     * @var int
     */
    private int $rounds = 0;

    /**
     * @var Player[]
     */
    private array $players = [];

    /**
     * @var Card[]
     */
    private array $cardsPlayed;

    /**
     * @var Player
     */
    private Player $loser;

    /**
     * @var bool|null
     */
    private ?bool $gameOver;

    /**
     * @return int
     */
    public function getRounds(): int
    {
        return $this->rounds;
    }

    /**
     * @param int $rounds
     */
    public function setRounds(int $rounds): void
    {
        $this->rounds = $rounds;
    }

    /**
     *
     */
    public function newRound()
    {
        $this->rounds ++;
    }

    /**
     * @return Player[]
     */
    public function getPlayers(): array
    {
        return $this->players;
    }

    /**
     * @param Player[] $players
     */
    public function setPlayers(array $players): void
    {
        $this->players = $players;
    }

    /**
     * @return Card[]
     */
    public function getCardsPlayed(): array
    {
        return $this->cardsPlayed ?? [];
    }

    /**
     * @param Card[] $cardsPlayed
     */
    public function setCardsPlayed(array $cardsPlayed): void
    {
        $this->cardsPlayed = $cardsPlayed;
    }

    /**
     * @return Player
     */
    public function getLoser(): Player
    {
        return $this->loser;
    }

    /**
     * @param Player $loser
     */
    public function setLoser(Player $loser): void
    {
        $this->loser = $loser;
    }

    /**
     *
     */
    public function gameOver(): void
    {
        $this->gameOver = true;
    }

    /**
     * @return bool
     */
    public function isGameOver(): bool
    {
        return $this->gameOver ?? false;
    }
}
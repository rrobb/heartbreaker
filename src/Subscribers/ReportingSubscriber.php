<?php
declare(strict_types = 1);

namespace Heartbreaker\Subscribers;

use Heartbreaker\Entities\Card;
use Heartbreaker\Entities\Player;
use Sabre\Event\Emitter;

/**
 * Class ReportingSubscriber
 * Reports on all in-game events
 * @package Heartbreaker\Subscribers
 */
class ReportingSubscriber
{
    /**
     * ReportingSubscriber constructor.
     * @param Emitter $emitter
     */
    public function __construct(Emitter $emitter)
    {
        $emitter->on('startGame', function ($players) {
            $this->onStartGame($players);
        });
        $emitter->on('playTurn', function ($player, $card) {
            $this->onPlayCardMessage($player, $card);
        });
        $emitter->on('loserOfRound', function ($player, $losingCard) {
            $this->onLoserOfRound($player, $losingCard);
        });
        $emitter->on('loserAddPoints', function ($points) {
            $this->onAddPoints($points);
        }, 20);
        $emitter->on('loserTotalPoints', function ($player) {
            $this->onTotalPoints($player);
        }, 20);
        $emitter->on('newRound', function ($rounds, $player) {
            $this->onNewRound($rounds, $player);
        });
        $emitter->on('gameOver', function ($player, $players) {
            $this->onGameOver($player, $players);
        });
        $emitter->on('reshuffle', function () {
            $this->onReshuffle();
        });
    }

    /**
     * @param Player[] $players
     */
    public function onStartGame(array $players)
    {
        echo PHP_EOL . sprintf('Starting a game with %s, %s, %s and %s', ... $players) . PHP_EOL;
        foreach ($players as $player) {
            echo PHP_EOL . $player . ' has been dealt ' . $player->getHand();
        }
    }

    /**
     * @param Player $player
     * @param Card $card
     */
    public function onPlayCardMessage(Player $player, Card $card)
    {
        echo PHP_EOL . $player . ' plays: ' . $card;
    }

    /**
     * @param int $points
     */
    public function onAddPoints(int $points)
    {
        echo sprintf(
            '%d points added to their total score. ',
            $points,
        );
    }

    /**
     * @param Player $player
     */
    public function onTotalPoints(Player $player)
    {
        echo sprintf(
            '%s\'s total score is now %d points.',
            $player,
            $player->getPoints()
        );
    }

    /**
     * @param int $rounds
     * @param Player $player
     */
    public function onNewRound(int $rounds, Player $player)
    {
        echo PHP_EOL . PHP_EOL . sprintf('Round %d: %s starts the round', $rounds, $player) . PHP_EOL;
    }

    /**
     * @param Player $player
     * @param Card $losingCard
     */
    public function onLoserOfRound(Player $player, Card $losingCard)
    {
        echo PHP_EOL . PHP_EOL . $player . sprintf(
                ' played %s%s, the highest matching card of this match and got ',
                $losingCard->getSuit(),
                $losingCard->getName()
            );
    }

    /**
     *
     */
    public function onReshuffle()
    {
        echo PHP_EOL . PHP_EOL . 'Players ran out of cards. Reshuffle.';
    }

    /**
     * @param Player $loserOfRound
     * @param Player[] $players
     */
    public function onGameOver(Player $loserOfRound, array $players)
    {
        echo PHP_EOL . PHP_EOL . sprintf('%s loses the game!', $loserOfRound);
        echo PHP_EOL . 'Points:';
        foreach($players as $player) {
            echo PHP_EOL . sprintf('%s: %d', $player, $player->getPoints());
        }
    }
}
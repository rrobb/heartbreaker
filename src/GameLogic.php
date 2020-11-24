<?php
declare(strict_types = 1);

namespace Heartbreaker;

use Heartbreaker\Entities\Card;
use Heartbreaker\Entities\Player;
use Heartbreaker\Factories\CardFactory;
use Heartbreaker\Factories\PlayerFactory;

class GameLogic
{
    public const NUMBER_OF_PLAYERS = 4;

    public const FIRST_PLAYER = 0;

    /**
     * @return Player|null
     */
    public function playGame()
    {
        $players = $this->setupGameWorld();
        echo PHP_EOL . sprintf('Starting a game with %s, %s, %s and %s', ... $players) . PHP_EOL;
        foreach ($players as $player) {
            echo PHP_EOL . $player . ' has been dealt ' . $player->getHand();
        }

        $rounds = 0;
        $lost = false;
        while (!$lost) {
            $rounds ++;
            echo PHP_EOL . PHP_EOL . sprintf('Round %d: %s starts the game', $rounds, $players[0]) . PHP_EOL;
            $cardsPlayed = $this->playRound($players);

            $loserOfRound = $this->getLoserOfRound($cardsPlayed, $players);
            $points = $this->getRoundPoints($cardsPlayed);
            $loserOfRound->addPoints($points);
            echo sprintf(
                '%d points added to their total score. %s\'s total score is now %d points.',
                $points,
                $loserOfRound,
                $loserOfRound->getPoints()
            );

            $lost = $this->checkIfGameOver($loserOfRound);

            $players = $this->continueWithNextPlayer($players);
            if ($rounds % 8 === 0) {
                echo PHP_EOL . PHP_EOL . 'Players ran out of cards. Reshuffle.';

                $this->shuffleAndDealCards($players);
            }
        }

        echo PHP_EOL . PHP_EOL . sprintf('%s loses the game!', $loserOfRound);
        echo PHP_EOL . 'Points:';
        foreach($players as $player) {
            echo PHP_EOL . sprintf('%s: %d', $player, $player->getPoints());
        }
        return $loserOfRound ?? null;
    }

    /**
     * Set up the game world by:
     * Adding four players and randomizing their seat order.
     * Give each player a hand of 8 random cards.
     * @return Player[] array
     */
    public function setupGameWorld(): array
    {
        $players = $this->randomizeSeatOrder(PlayerFactory::addPlayers());

        return $this->shuffleAndDealCards($players);
    }

    /**
     * Shuffle the cards and distribute them among the players.
     * @param $players
     * @return mixed
     */
    public function shuffleAndDealCards($players)
    {
        $shuffledDeck = $this->shuffleDeck(CardFactory::createCardDeck());
        $this->dealCards($shuffledDeck, $players);

        return $players;
    }

    /**
     * Here we set the player order, randomized for each new game.
     * @param Player[] $players
     * @return Player[]
     */
    public function randomizeSeatOrder(array $players): array
    {
        shuffle($players);

        return $players;
    }

    /**
     * Take the deck of cards and return it shuffled.
     * @param Card[] $deck
     * @return Card[]
     */
    public function shuffleDeck(array $deck): array
    {
        shuffle($deck);

        return $deck;
    }

    /**
     * Here we deal the cards, taking the (pre-shuffled) deck and distributing the cards round-robin among the players
     * @param Card[] $deck
     * @param Player[] $players
     */
    public function dealCards(array $deck, array $players)
    {
        $count = count($players);
        foreach ($deck as $i => $card)
        {
            $player = $players[$i % $count];
            $player->getHand()->addCard($card);
        }
    }

    /**
     * Play a round by having each player play one card.
     * @param Player[] $players
     * @return Card[]
     */
    public function playRound(array $players): array
    {
        foreach ($players as $turn => $player) {
            $cardsPlayed[] = $player->playTurn($cardsPlayed ?? []);
        }

        return $cardsPlayed ?? [];
    }

    /**
     * Business rule "the player that played the highest matching card loses the round"
     * The player playing the highest value card matching the suit of the first card played loses the round.
     * @param array $cardsPlayed
     * @param array $players
     * @return Player
     */
    public function getLoserOfRound(array $cardsPlayed, array $players): Player
    {
        $currentSuit = GameRules::currentSuit($cardsPlayed);
        $highestValue = 0;
        $highestName = $cardsPlayed[0]->getName();
        foreach ($cardsPlayed as $playerOrder => $card) {
            /** @var Card $card */
            if (
                $card->getSuit() === $currentSuit &&
                $card->getValue() > $highestValue
            ) {
                $highestValue = $card->getValue();
                $loser = $playerOrder;
                $highestName = $card->getName();
            }
        }
        $player = $loser ?? self::FIRST_PLAYER;
        echo PHP_EOL . PHP_EOL . $players[$player] . sprintf(
            ' played %s%s, the highest matching card of this match and got ',
            $currentSuit,
            $highestName
            );

        return $players[$player];
    }

    /**
     * Add up and return all points in the current round of play.
     * @param array $cardsPlayed
     * @return int
     */
    public function getRoundPoints(array $cardsPlayed): int
    {
        $points = 0;
        foreach ($cardsPlayed as $playerOrder => $card) {
            $points += GameRules::cardPoints($card);
        }

        return $points;
    }

    /**
     * If the most recent losing player exceeds the maximum allowed amount of points, they lose and the game is over.
     * @param Player $player
     * @return bool
     */
    public function checkIfGameOver(Player $player): bool
    {
        return $player->getPoints() >= GameRules::losingScore();
    }

    /**
     * Business rule "the next rounds starts with the next player"
     * After a round is finished we move the starting player to the end of the line.
     * @param array $players
     * @return array
     */
    public function continueWithNextPlayer(array $players): array
    {
        $played = array_shift($players);
        array_push($players, $played);

        return $players;
    }

    /**
     * The 'worst card' played is the card that has the highest value of all cards currently played on-suit.
     * This is the card the current player has to beat to not lose the round.
     * @param array $cardsPlayed
     * @return Card
     */
    public static function pickWorstCardPlayed(array $cardsPlayed): Card
    {
        $currentSuit = GameRules::currentSuit($cardsPlayed);
        $playedOnSuit = array_filter($cardsPlayed, function (Card $card) use ($currentSuit) {
            return $card->getSuit() === $currentSuit;
        });

        return array_reduce(
            $playedOnSuit,
            function (?Card $carry, Card $card) {
                if ($card->getValue() > $carry->getValue()) {
                    return $card;
                }
                return $card;
            },
            $playedOnSuit[0]
        );
    }
}
<?php
declare(strict_types = 1);

namespace Heartbreaker\Handlers;

use Heartbreaker\Entities\Game;

/**
 * Interface HandlerInterface
 * @package Heartbreaker\Handlers
 */
interface HandlerInterface
{
    /**
     * Sets the next handler in the chain
     * @param HandlerInterface $handler
     * @return HandlerInterface
     */
    public function setNext(HandlerInterface $handler): HandlerInterface;

    /**
     * Handles the request
     * @param Game $round
     * @return Game|null
     */
    public function handle(Game $round): ?Game;

    /**
     * Emits an event
     * @param string $eventName
     * @param array $arguments
     * @param callable|null $continueCallBack
     * @return bool
     */
    public function emit(string $eventName, array $arguments = [], callable $continueCallBack = null): bool;
}
<?php
declare(strict_types=1);

namespace Heartbreaker\Handlers;

use Heartbreaker\Entities\Game;
use Sabre\Event\Emitter;

/**
 * Class AbstractHandler
 * @package Heartbreaker\Handlers
 */
abstract class AbstractHandler implements HandlerInterface
{
    /**
     * @var ?HandlerInterface
     */
    private ?HandlerInterface $nextHandler = null;

    /**
     * @var Emitter
     */
    protected Emitter $emitter;

    /**
     * AbstractHandler constructor.
     * @param Emitter $emitter
     */
    public function __construct(Emitter $emitter)
    {
        $this->emitter = $emitter;
    }

    /**
     * @inheritDoc
     */
    public function setNext(HandlerInterface $handler): HandlerInterface
    {
        $this->nextHandler = $handler;

        return $handler;
    }

    /**
     * @inheritDoc
     */
    public function handle(Game $request): ?Game
    {
        if ($this->nextHandler !== null) {
            return $this->nextHandler->handle($request);
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function emit(string $eventName, array $arguments = [], callable $continueCallBack = null): bool
    {
        return $this->emitter->emit($eventName, $arguments, $continueCallBack);
    }
}
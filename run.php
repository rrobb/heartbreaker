<?php
require 'vendor/autoload.php';
use Heartbreaker\Factories\GameLogicFactory;
use Sabre\Event\Emitter;

$gamelogic = GameLogicFactory::createGameLogic(new Emitter());
$gamelogic->gameLoop();
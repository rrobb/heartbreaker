<?php
declare(strict_types = 1);

use Heartbreaker\Factories\CardFactory;
use PHPUnit\Framework\TestCase;

class CardFactoryTest extends TestCase
{
    public function testCreateCardDeck()
    {
        $stack = CardFactory::createCardDeck();
        $this->assertCount(32, $stack);
        foreach ($stack as $item) {
            echo $item . PHP_EOL;
        }
    }
}

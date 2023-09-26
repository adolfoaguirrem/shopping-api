<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Buyer\Buyer;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Domain\Buyer\ValueObject\BuyerName;

class BuyerTest extends TestCase
{
    public function testBuyerConstructor()
    {
        $buyer = new Buyer(
            new BuyerName('John Doe')
        );

        $this->assertInstanceOf(Buyer::class, $buyer);
        $this->assertEquals('John Doe', $buyer->getName()->value());
    }

    public function test_buyer_set_new_name()
    {
        $buyer = new Buyer(
            new BuyerName('Old Name')
        );

        $newName = new BuyerName('New Name');
        $buyer->setName($newName);

        $this->assertEquals('New Name', $buyer->getName()->value());
    }

    public function test_buyer_set_invalid_new_name()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name cannot be an empty string.');

        $buyer = new Buyer(
            new BuyerName('Old Name')
        );

        $newName = new BuyerName('');
        $buyer->setName($newName);

        $this->assertEquals('New Name', $buyer->getName()->value());
    }
}

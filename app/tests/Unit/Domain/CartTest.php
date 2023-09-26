<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Cart\Cart;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use App\Domain\Cart\ValueObject\CartStatus;

class CartTest extends TestCase
{
    public function test_cart_constructor()
    {
        $buyerId = 1;
        $status = new CartStatus(CartStatus::OPEN);
        $cart = new Cart($buyerId, $status);

        $this->assertInstanceOf(Cart::class, $cart);
        $this->assertEquals('open', $cart->getStatus()->value());
    }

    public function testGetCartStatusValue()
    {
        $status = new CartStatus(CartStatus::PENDING);
        $this->assertEquals(CartStatus::PENDING, $status->value());
    }

    public function test_create_invalid_staus()
    {
        $this->expectException(InvalidArgumentException::class);
        $status = new CartStatus('invalid_status');
    }

    public function test_cart_set_new_status()
    {
        $buyerId = 1;
        $status = new CartStatus(CartStatus::OPEN);
        $cart = new Cart($buyerId, $status);

        $new_status = new CartStatus(CartStatus::PENDING);
        $cart->setStatus($new_status);

        $this->assertEquals('pending', $cart->getStatus()->value());
    }


}

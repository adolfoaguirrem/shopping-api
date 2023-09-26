<?php

namespace App\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use App\Domain\CartProduct\CartProduct;

class CartProductTest extends TestCase
{
    public function test_modify_quantity()
    {
        $cart_id = 1;
        $produc_id = 1;

        $cartProduct = new CartProduct($cart_id, $produc_id);
        $cartProduct->increaseQuantity();

        // test getters
        $this->assertEquals(1, $cartProduct->getCartId());
        $this->assertEquals(1, $cartProduct->getProductId());
        $this->assertEquals(1, $cartProduct->getQuantity());

        // Testing methods of increasing and decreasing quantities.
        $cartProduct->increaseQuantity();
        $this->assertEquals(2, $cartProduct->getQuantity());

        $cartProduct->decreaseQuantity();
        $this->assertEquals(1, $cartProduct->getQuantity());
    }

}

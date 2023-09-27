<?php

namespace App\Tests\Unit\Domain;

use App\Domain\Cart\Cart;
use App\Domain\Cart\ValueObject\CartStatus;
use App\Domain\Product\Product;
use PHPUnit\Framework\TestCase;
use App\Domain\CartProduct\CartProduct;
use App\Domain\Product\ValueObject\ProductName;
use App\Domain\Product\ValueObject\ProductPrice;

class CartProductTest extends TestCase
{
    public function test_get_cart()
    {
        $cart = new Cart(1, new CartStatus(CartStatus::OPEN));
        $product = new Product(new ProductName('Mobile'), new ProductPrice(10.0));
        $cartProduct = new CartProduct($cart, $product);

        $this->assertSame($cart, $cartProduct->getCart());
    }

    public function test_increase_quantity()
    {
        $cart = new Cart(1, new CartStatus(CartStatus::OPEN));
        $product = new Product(new ProductName('Mobile'), new ProductPrice(10.0));
        $cartProduct = new CartProduct($cart, $product);

        $initialQuantity = $cartProduct->getQuantity();
        $cartProduct->increaseQuantity();

        $this->assertSame($initialQuantity + 1, $cartProduct->getQuantity());
    }

    public function test_decrease_quantity()
    {
        $cart = new Cart(1, new CartStatus(CartStatus::OPEN));
        $product = new Product(new ProductName('Mobile'), new ProductPrice(10.0));
        $cartProduct = new CartProduct($cart, $product);

        $initialQuantity = $cartProduct->getQuantity();
        $cartProduct->decreaseQuantity();

        $this->assertSame($initialQuantity - 1, $cartProduct->getQuantity());
    }

}

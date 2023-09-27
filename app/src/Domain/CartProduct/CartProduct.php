<?php

namespace App\Domain\CartProduct;

use App\Domain\Cart\Cart;
use App\Domain\Product\Product;

class CartProduct
{
    private ?int $id = null;
    private int $quantity = 0;
    private Cart $cart;
    private Product $product;

    public function __construct(Cart $cart, Product $product)
    {
        $this->cart = $cart;
        $this->product = $product;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCart(): Cart
    {
        return $this->cart;
    }

    public function setCart(Cart $cart): Cart
    {
        return $this->cart = $cart;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): Product
    {
        return $this->product = $product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity(): int
    {
        return $this->quantity++;
    }

    public function decreaseQuantity(): int
    {
        return $this->quantity--;
    }
}

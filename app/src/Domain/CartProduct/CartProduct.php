<?php

namespace App\Domain\CartProduct;

class CartProduct
{
    private ?int $id = null;
    private int $quantity = 0;

    public function __construct(private int $cart_id, private int $product_id)
    {
        $this->cart_id = $cart_id;
        $this->product_id = $product_id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCartId(): int
    {
        return $this->cart_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
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

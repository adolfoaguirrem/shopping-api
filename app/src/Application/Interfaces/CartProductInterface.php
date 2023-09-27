<?php

namespace App\Application\Interfaces;

use App\Domain\Cart\Cart;
use App\Domain\Product\Product;
use App\Domain\CartProduct\CartProduct;

interface CartProductInterface
{
    public function save(CartProduct $cart): CartProduct;
    public function findByCart(int $cart_id): array;
    public function findByCartAndProduct(Cart $cart, Product $product): ?CartProduct;
    public function delete(CartProduct $cartProduct): void;
}

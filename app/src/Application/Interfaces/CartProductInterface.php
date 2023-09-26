<?php

namespace App\Application\Interfaces;

use App\Domain\CartProduct\CartProduct;

interface CartProductInterface
{
    public function save(CartProduct $cart): CartProduct;
    public function getProductsOnCart(int $cart_id): array;
    public function getProductOnCart(int $cart_id, int $product_id): ?CartProduct;
    public function delete(CartProduct $cartProduct): void;
}

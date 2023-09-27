<?php

namespace App\Application\UseCases;

use App\Domain\CartProduct\CartProduct;
use App\Application\Interfaces\CartProductInterface;
use App\Domain\Cart\Cart;
use App\Domain\Product\Product;

class GetProductOnCartUseCase
{

    public function __construct(private CartProductInterface $cartProductInterface)
    {
    }

    public function execute(Cart $cart, Product $product): ?CartProduct
    {
        $cartProduct = $this->cartProductInterface->findByCartAndProduct($cart, $product);
        return $cartProduct;
    }
}

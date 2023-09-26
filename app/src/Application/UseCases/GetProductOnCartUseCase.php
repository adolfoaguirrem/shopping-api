<?php

namespace App\Application\UseCases;

use App\Domain\CartProduct\CartProduct;
use App\Application\UseCases\GetProductUseCase;
use App\Application\Interfaces\CartProductInterface;

class GetProductOnCartUseCase
{

    public function __construct(
        private CartProductInterface $cartProductInterface,
        private GetProductUseCase $getProductUseCase
    ) {
    }

    public function execute(int $cart_id, int $product_id): ?CartProduct
    {
        $product = $this->getProductUseCase->execute($product_id);
        $cartProduct = $this->cartProductInterface->getProductOnCart($cart_id, $product->getId());
        return $cartProduct;
    }
}

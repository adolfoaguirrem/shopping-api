<?php

namespace App\Application\UseCases;

use App\Application\UseCases\GetProductUseCase;
use App\Application\Interfaces\CartProductInterface;

class GetProductsOnCartUseCase
{

    public function __construct(
        private CartProductInterface $cartProductInterface,
        private GetProductUseCase $getProductUseCase
    ) {
    }

    public function execute(int $cart_id): array
    {
        $cartProducts = $this->cartProductInterface->getProductsOnCart($cart_id);

        $cartProducts_array = [];

        foreach ($cartProducts as $cartProduct) {

            $product = $this->getProductUseCase->execute($cartProduct->getProductId());

            $cartProducts_array[] = [
                'product' => $product->getName()->value(),
                'quantity' => $cartProduct->getQuantity()
            ];
        }

        return $cartProducts_array;
    }
}

<?php

namespace App\Application\UseCases;

use App\Domain\CartProduct\CartProduct;
use App\Application\UseCases\GetProductOnCartUseCase;
use App\Application\Interfaces\CartProductInterface;
use App\Application\UseCases\GetOpenCartByBuyerUseCase;

class AddProductToCartUseCase
{

    public function __construct(
        private CartProductInterface $cartProductRepository,
        private GetOpenCartByBuyerUseCase $getOpenCartByBuyerUseCase,
        private GetProductOnCartUseCase $getProductOnCartUseCase
    ) {
        // ...
    }

    public function execute(array $data)
    {
        $buyerId = $data['buyer_id'];
        $productId = $data['product_id'];

        $cart = $this->getOpenCartByBuyerUseCase->execute($buyerId);
        $cartProduct = $this->getProductOnCartUseCase->execute($cart->getId(), $productId);

        if (is_null($cartProduct)) {
            $cartProduct = new CartProduct($cart->getId(), $productId);
        }

        $cartProduct->increaseQuantity();
        $this->cartProductRepository->save($cartProduct);
        return $cartProduct;
    }
}

<?php

namespace App\Application\UseCases;

use App\Application\UseCases\GetOpenCartByBuyerUseCase;
use App\Application\Interfaces\CartProductInterface;
use App\Application\UseCases\GetProductOnCartUseCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DeleteProductOnCartUseCase
{

    public function __construct(
        private CartProductInterface $cartProductRepository,
        private GetOpenCartByBuyerUseCase $getOpenCartByBuyerUseCase,
        private GetProductOnCartUseCase $getProductOnCartUseCase
    ) {
    }

    public function execute(array $data)
    {
        $buyerId = $data['buyer_id'];
        $productId = $data['product_id'];

        $cart = $this->getOpenCartByBuyerUseCase->execute($buyerId);
        $cartProduct = $this->getProductOnCartUseCase->execute($cart->getId(), $productId);

        if (is_null($cartProduct)) {
            return throw new NotFoundHttpException('Product not found in Cart');
        }

        if ($cartProduct->getQuantity() > 1) {
            $cartProduct->decreaseQuantity();
            $cartProduct = $this->cartProductRepository->save($cartProduct);
        } else {
            $this->cartProductRepository->delete($cartProduct);
        }

        return $cartProduct;
    }
}

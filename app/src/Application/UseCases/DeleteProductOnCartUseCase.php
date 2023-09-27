<?php

namespace App\Application\UseCases;

use App\Application\UseCases\GetProductUseCase;
use App\Application\Interfaces\CartProductInterface;
use App\Application\UseCases\GetProductOnCartUseCase;
use App\Application\UseCases\GetOpenCartByBuyerUseCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class DeleteProductOnCartUseCase
{

    public function __construct(
        private CartProductInterface $cartProductRepository,
        private GetOpenCartByBuyerUseCase $getOpenCartByBuyerUseCase,
        private GetProductOnCartUseCase $getProductOnCartUseCase,
        private GetProductUseCase $getProductUseCase
    ) {
    }

    public function execute(array $data)
    {
        $buyerId = $data['buyer_id'];
        $productId = $data['product_id'];

        $cart = $this->getOpenCartByBuyerUseCase->execute($buyerId);
        $product = $this->getProductUseCase->execute($productId);
        $cartProduct = $this->getProductOnCartUseCase->execute($cart, $product);

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

<?php

namespace App\Application\UseCases;

use App\Domain\Cart\Cart;
use App\Application\Interfaces\CartInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetCartUseCase
{

    public function __construct(private CartInterface $cartRepository)
    {
    }

    public function execute(int $id): array
    {
        $cart = $this->cartRepository->findById($id);

        if (is_null($cart)) {
            return throw new NotFoundHttpException('Cart not found');
        }

        $cartDetails = [];

        foreach ($cart->getCartProducts() as $cartProduct) {
            $product = $cartProduct->getProduct();
            $cartDetails[] = [
                'product_id' => $product->getId(),
                'product_name' => $product->getName()->value(),
                'quantity' => $cartProduct->getQuantity(),
            ];
        }

        $response = [
            'cart' => [
                'id' => $cart->getId(),
                'buyer_id' => $cart->getBuyerId()
            ],
            'products' => $cartDetails,
        ];

        return $response;
    }
}

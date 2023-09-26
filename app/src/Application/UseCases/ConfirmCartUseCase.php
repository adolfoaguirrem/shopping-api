<?php

namespace App\Application\UseCases;

use App\Domain\Cart\Cart;
use App\Domain\Cart\ValueObject\CartStatus;
use App\Application\Interfaces\CartInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConfirmCartUseCase
{

    public function __construct(private CartInterface $cartRepository)
    {
    }

    public function execute(int $cart_id): ?Cart
    {
        $cart = $this->cartRepository->findById($cart_id);

        if (is_null($cart)) {
            return throw new NotFoundHttpException('Cart not found');
        }

        $cart->setStatus(new CartStatus(CartStatus::COMPLETE));
        $cart = $this->cartRepository->update($cart);

        return $cart;
    }
}

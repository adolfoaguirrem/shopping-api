<?php

namespace App\Application\UseCases;

use App\Domain\Cart\Cart;
use App\Domain\Cart\ValueObject\CartStatus;
use App\Application\Interfaces\CartInterface;
use App\Application\UseCases\GetBuyerUseCase;

class GetOpenCartByBuyerUseCase
{

    public function __construct(
        private CartInterface $cartRepository,
        private GetBuyerUseCase $getBuyerUseCase
    ) {
    }

    public function execute(int $buyerId): ?Cart
    {
        $buyer = $this->getBuyerUseCase->execute($buyerId);
        $cart = $this->cartRepository->getOpenByBuyer($buyer->getId());

        if (is_null($cart)) {

            $cart = new Cart(
                $buyer->getId(),
                new CartStatus(CartStatus::OPEN)
            );

            $cart = $this->cartRepository->save($cart);
        }

        return $cart;
    }
}

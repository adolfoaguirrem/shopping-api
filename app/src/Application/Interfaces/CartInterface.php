<?php

namespace App\Application\Interfaces;

use App\Domain\Cart\Cart;

interface CartInterface
{
    public function save(Cart $cart): Cart;
    public function findById(int $cart_id): ?Cart;
    public function getOpenByBuyerId(int $buyer_id): ?Cart;
    public function update(Cart $cart): Cart;
}

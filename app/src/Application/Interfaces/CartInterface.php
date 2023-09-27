<?php

namespace App\Application\Interfaces;

use App\Domain\Cart\Cart;

interface CartInterface
{
    public function save(Cart $cart): Cart;
    public function findById(int $id): ?Cart;
    public function getOpenByBuyer(int $buyer_id): ?Cart;
    public function update(Cart $cart): Cart;
}

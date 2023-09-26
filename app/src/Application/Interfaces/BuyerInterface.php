<?php

namespace App\Application\Interfaces;

use App\Domain\Buyer\Buyer;

interface BuyerInterface
{
    public function save(Buyer $buyer): void;
    public function findById(int $id): ?Buyer;
    public function findAll(): array;
}

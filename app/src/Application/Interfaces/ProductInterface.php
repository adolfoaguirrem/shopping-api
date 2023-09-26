<?php

namespace App\Application\Interfaces;

use App\Domain\Product\Product;

interface ProductInterface
{
    public function save(Product $product): void;
    public function findById(int $id): ?Product;
    public function findAll(): array;
}

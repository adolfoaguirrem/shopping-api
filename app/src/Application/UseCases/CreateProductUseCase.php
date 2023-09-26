<?php

namespace App\Application\UseCases;

use App\Domain\Product\Product;
use App\Application\Interfaces\ProductInterface;
use App\Domain\Product\ValueObject\ProductName;
use App\Domain\Product\ValueObject\ProductPrice;

class CreateProductUseCase
{
    public function __construct(private ProductInterface $productRepository)
    {
    }

    public function execute($data): Product
    {
        $product = new Product(
            new ProductName($data['name']),
            new ProductPrice($data['price'])
        );

        $this->productRepository->save($product);

        return $product;
    }
}

<?php

namespace App\Application\UseCases;

use App\Domain\Product\Product;
use App\Application\Interfaces\ProductInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetProductUseCase
{
    public function __construct(private ProductInterface $productRepository)
    {
    }

    public function execute($productId): Product
    {

        $product = $this->productRepository->findById($productId);

        if (is_null($product)) {
            return throw new NotFoundHttpException('Product not found');
        }

        return $product;
    }
}

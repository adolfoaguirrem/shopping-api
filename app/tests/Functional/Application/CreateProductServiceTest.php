<?php

namespace App\Tests\Functional\Application;

use App\Domain\Product\Product;
use PHPUnit\Framework\TestCase;
use App\Application\UseCases\CreateProductUseCase;
use App\Infrastructure\Doctrine\Repository\DoctrineProductRepository;

class CreateProductUseCaseTest extends TestCase
{
    public function test_create_product_use_case()
    {
        $repository = $this->createMock(DoctrineProductRepository::class);
        $repository->expects($this->once())->method('save');

        $requestParams = [
            'name' => "Test Product",
            'price' => 100.0,
        ];

        $createProductUseCase = new CreateProductUseCase($repository);
        $product = $createProductUseCase->execute($requestParams);

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Test Product', $product->getName()->value());
        $this->assertEquals(100.0, $product->getPrice()->value());
    }
}

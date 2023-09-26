<?php

namespace App\Tests\Unit\Domain;

use InvalidArgumentException;
use App\Domain\Product\Product;
use PHPUnit\Framework\TestCase;
use App\Domain\Product\ValueObject\ProductName;
use App\Domain\Product\ValueObject\ProductPrice;

class ProductTest extends TestCase
{
    public function test_product_constructor()
    {
        $product = new Product(
            new ProductName('Test Product'),
            new ProductPrice(100.0)
        );

        $this->assertInstanceOf(Product::class, $product);
        $this->assertEquals('Test Product', $product->getName()->value());
        $this->assertEquals(100.0, $product->getPrice()->value());
    }

    public function test_product_set_new_name()
    {
        $product = new Product(
            new ProductName('Old Name'),
            new ProductPrice(100.0)
        );

        $newName = new ProductName('New Name');
        $product->setName($newName);

        $this->assertEquals('New Name', $product->getName()->value());
    }

    public function test_product_set_new_price()
    {

        $product = new Product(
            new ProductName('Test Product'),
            new ProductPrice(100.0)
        );

        $newPrice = new ProductPrice(150.0);

        $product->setPrice($newPrice);
        $this->assertEquals(150.0, $product->getPrice()->value());
    }

    public function test_product_set_invalid_new_price()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The price cannot be less than 0.');

        $product = new Product(
            new ProductName('Test Product'),
            new ProductPrice(100.0)
        );

        $newPrice = new ProductPrice(-150.0);
        $product->setPrice($newPrice);
    }
}

<?php

namespace App\Tests\Functional\Application;

use App\Domain\Cart\Cart;
use App\Domain\Product\Product;
use PHPUnit\Framework\TestCase;
use App\Domain\CartProduct\CartProduct;
use App\Domain\Cart\ValueObject\CartStatus;
use App\Application\UseCases\GetProductUseCase;
use App\Domain\Product\ValueObject\ProductName;
use App\Domain\Product\ValueObject\ProductPrice;
use App\Application\Interfaces\CartProductInterface;
use App\Application\UseCases\AddProductToCartUseCase;
use App\Application\UseCases\GetProductOnCartUseCase;
use App\Application\UseCases\GetOpenCartByBuyerUseCase;

class AddProductToCartUseCaseTest extends TestCase
{
    public function test_add_product_action()
    {
        // Mock dependencies
        $cartProductRepository = $this->createMock(CartProductInterface::class);
        $getOpenCartByBuyerUseCase = $this->createMock(GetOpenCartByBuyerUseCase::class);
        $getProductOnCartUseCase = $this->createMock(GetProductOnCartUseCase::class);
        $getProductUseCase = $this->createMock(GetProductUseCase::class);

        // Create an instance of AddProductToCartUseCase
        $addProductToCartUseCase = new AddProductToCartUseCase(
            $cartProductRepository,
            $getOpenCartByBuyerUseCase,
            $getProductOnCartUseCase,
            $getProductUseCase
        );

        // Define test data
        $buyerId = 1;
        $productId = 123;

        $cart = new Cart($buyerId, new CartStatus(CartStatus::OPEN));
        $cart->setId(1);

        $product = new Product(
            new ProductName('Test Product'),
            new ProductPrice(100.0)
        );

        $product->setId(123);

        $getOpenCartByBuyerUseCase
            ->expects($this->once())
            ->method('execute')
            ->with($buyerId)
            ->willReturn($cart);

        $getProductUseCase
            ->expects($this->once())
            ->method('execute')
            ->with($productId)
            ->willReturn($product);

        $cartProduct = null; // Set to null to simulate that the product doesn't exist initially

        $getProductOnCartUseCase
            ->expects($this->once())
            ->method('execute')
            ->with($cart, $product)
            ->willReturn($cartProduct);

        // Expectations for the cart product repository
        $cartProductRepository->expects($this->once())
            ->method('save')
            ->with($this->isInstanceOf(CartProduct::class));

        // Execute the use case
        $result = $addProductToCartUseCase->execute([
            'buyer_id' => $buyerId,
            'product_id' => $productId,
        ]);

        // Assert the result or any other necessary assertions
        $this->assertInstanceOf(CartProduct::class, $result);
    }
}

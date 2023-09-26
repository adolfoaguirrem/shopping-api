<?php

namespace App\Tests\Functional\Application;

use App\Domain\Cart\Cart;
use PHPUnit\Framework\TestCase;
use App\Domain\CartProduct\CartProduct;
use App\Domain\Cart\ValueObject\CartStatus;
use App\Application\Interfaces\CartProductInterface;
use App\Application\UseCases\AddProductToCartUseCase;
use App\Application\UseCases\GetOpenCartByBuyerUseCase;
use App\Application\UseCases\GetProductOnCartUseCase;

class AddProductToCartUseCaseTest extends TestCase
{
    public function test_add_product_action()
    {
        // Mock dependencies
        $cartProductRepository = $this->createMock(CartProductInterface::class);
        $getOpenCartByBuyerUseCase = $this->createMock(GetOpenCartByBuyerUseCase::class);
        $getProductOnCartUseCase = $this->createMock(GetProductOnCartUseCase::class);

        // Create an instance of AddProductToCartUseCase
        $addProductToCartUseCase = new AddProductToCartUseCase(
            $cartProductRepository,
            $getOpenCartByBuyerUseCase,
            $getProductOnCartUseCase
        );

        // Define test data
        $buyerId = 1;
        $productId = 123;

        // Mock the expected behavior of your dependencies
        $cart = new Cart($buyerId, new CartStatus(CartStatus::OPEN));
        $cart->setId(1);

        $getOpenCartByBuyerUseCase
            ->expects($this->once())
            ->method('execute')
            ->with($buyerId)
            ->willReturn($cart);

        $cartProduct = null; // Set to null to simulate that the product doesn't exist initially

        $getProductOnCartUseCase
            ->expects($this->once())
            ->method('execute')
            ->with($cart->getId(), $productId)
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

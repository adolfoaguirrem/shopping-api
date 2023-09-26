<?php

namespace App\Tests\Functional\Application;

use App\Domain\Cart\Cart;
use PHPUnit\Framework\TestCase;
use App\Domain\CartProduct\CartProduct;
use App\Domain\Cart\ValueObject\CartStatus;
use App\Application\Interfaces\CartProductInterface;
use App\Application\UseCases\GetOpenCartByBuyerUseCase;
use App\Application\UseCases\GetProductOnCartUseCase;
use App\Application\UseCases\DeleteProductOnCartUseCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DeleteProductOnCartUseCaseTest extends TestCase
{
    public function test_delete_existing_product_with_quantity_greater_than_one()
    {
        // Mock dependencies
        $cartProductRepository = $this->createMock(CartProductInterface::class);
        $getOpenCartByBuyerUseCase = $this->createMock(GetOpenCartByBuyerUseCase::class);
        $getProductOnCartUseCase = $this->createMock(GetProductOnCartUseCase::class);

        // Create an instance of DeleteProductOnCartUseCase with mocked dependencies
        $deleteProductOnCartUseCase = new DeleteProductOnCartUseCase(
            $cartProductRepository,
            $getOpenCartByBuyerUseCase,
            $getProductOnCartUseCase
        );

        // Define test data
        $buyerId = 1;
        $productId = 2;

        // Mock cart product
        $cartProduct = new CartProduct(1, $productId);
        $cartProduct->increaseQuantity(); // Quantity 1
        $cartProduct->increaseQuantity(); // Quantity 2

        $cart = new Cart($buyerId, new CartStatus(CartStatus::OPEN));
        $cart->setId(1);

        $getOpenCartByBuyerUseCase
            ->expects($this->once())
            ->method('execute')
            ->with($buyerId)
            ->willReturn($cart);

        // Set expectations for dependencies
        $getOpenCartByBuyerUseCase->expects($this->once())
            ->method('execute')
            ->with($buyerId)
            ->willReturn($cart);

        $getProductOnCartUseCase->expects($this->once())
            ->method('execute')
            ->with(1, $productId)
            ->willReturn($cartProduct);

        $cartProductRepository->expects($this->once())
            ->method('save')
            ->with($cartProduct)
            ->willReturn($cartProduct);

        // Execute the use case
        $deleteProductOnCartUseCase->execute([
            'buyer_id' => $buyerId,
            'product_id' => $productId,
        ]);

        $this->assertEquals(1, $cartProduct->getQuantity());
    }

    public function test_delete_non_existing_product()
    {
        // Mock dependencies
        $cartProductRepository = $this->createMock(CartProductInterface::class);
        $getOpenCartByBuyerUseCase = $this->createMock(GetOpenCartByBuyerUseCase::class);
        $getProductOnCartUseCase = $this->createMock(GetProductOnCartUseCase::class);

        // Create an instance of DeleteProductOnCartUseCase with mocked dependencies
        $deleteProductOnCartUseCase = new DeleteProductOnCartUseCase(
            $cartProductRepository,
            $getOpenCartByBuyerUseCase,
            $getProductOnCartUseCase
        );

        // Define test data
        $buyerId = 1;
        $productId = 2;

        // Mock the expected behavior of your dependencies
        $cart = new Cart($buyerId, new CartStatus(CartStatus::OPEN));
        $cart->setId(1);

        // Set expectations for dependencies
        $getOpenCartByBuyerUseCase->expects($this->once())
            ->method('execute')
            ->with($buyerId)
            ->willReturn($cart); // Create a valid Cart object

        $getProductOnCartUseCase->expects($this->once())
            ->method('execute')
            ->with(1, $productId) // Assuming cart ID is 1
            ->willReturn(null); // Simulate that the product doesn't exist

        // Expect a NotFoundHttpException to be thrown
        $this->expectException(NotFoundHttpException::class);

        // Execute the use case
        $deleteProductOnCartUseCase->execute([
            'buyer_id' => $buyerId,
            'product_id' => $productId,
        ]);
    }
}

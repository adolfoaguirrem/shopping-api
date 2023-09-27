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
use App\Application\UseCases\GetProductOnCartUseCase;
use App\Application\UseCases\GetOpenCartByBuyerUseCase;
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
        $getProductUseCase = $this->createMock(GetProductUseCase::class);

        // Create an instance of DeleteProductOnCartUseCase with mocked dependencies
        $deleteProductOnCartUseCase = new DeleteProductOnCartUseCase(
            $cartProductRepository,
            $getOpenCartByBuyerUseCase,
            $getProductOnCartUseCase,
            $getProductUseCase
        );

        // Define test data
        $buyerId = 1;
        $productId = 2;

        // Mock cart product

        $cart = new Cart($buyerId, new CartStatus(CartStatus::OPEN));
        $cart->setId(1);

        $product = new Product(
            new ProductName('Test Product'),
            new ProductPrice(100.0)
        );

        $product->setId(123);

        $cartProduct = new CartProduct($cart, $product);
        $cartProduct->increaseQuantity(); // Quantity 1
        $cartProduct->increaseQuantity(); // Quantity 2

        // Set expectations for dependencies
        $getOpenCartByBuyerUseCase->expects($this->once())
            ->method('execute')
            ->with($buyerId)
            ->willReturn($cart);

        $getProductUseCase
            ->expects($this->once())
            ->method('execute')
            ->with($productId)
            ->willReturn($product);

        $getProductOnCartUseCase->expects($this->once())
            ->method('execute')
            ->with($cart, $product)
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
}

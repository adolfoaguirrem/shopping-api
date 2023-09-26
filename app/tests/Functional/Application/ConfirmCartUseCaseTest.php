<?php

namespace App\Tests\Functional\Application;

use App\Domain\Cart\Cart;
use PHPUnit\Framework\TestCase;
use App\Domain\Cart\ValueObject\CartStatus;
use App\Application\Interfaces\CartInterface;
use App\Application\UseCases\ConfirmCartUseCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ConfirmCartUseCaseTest extends TestCase
{
    public function test_confirm_an_open_cart()
    {
        // Mock
        $cartRepository = $this->createMock(CartInterface::class);

        // CCheck if Cart exist
        $existingCart = new Cart(1, new CartStatus(CartStatus::OPEN));
        $cartRepository->expects($this->once())
            ->method('findById')
            ->with(1)
            ->willReturn($existingCart);

        // Update status
        $cartRepository->expects($this->once())
            ->method('update')
            ->with($existingCart)
            ->willReturn($existingCart);

        $useCase = new ConfirmCartUseCase($cartRepository);
        $confirmedCart = $useCase->execute(1);

        $this->assertInstanceOf(Cart::class, $confirmedCart);
        $this->assertEquals(CartStatus::COMPLETE, $confirmedCart->getStatus()->value());
    }

    public function test_confirm_with_invalid_id()
    {
        // Mock the cart repository
        $cartRepository = $this->createMock(CartInterface::class);

        // Configure the mock to expect the findById method call
        $cartRepository->expects($this->once())
            ->method('findById')
            ->with(1) // Assuming cart_id 1 does not exist
            ->willReturn(null);

        // Use case
        $useCase = new ConfirmCartUseCase($cartRepository);

        // Verify that a NotFoundHttpException is thrown
        $this->expectException(NotFoundHttpException::class);
        $useCase->execute(1);
    }
}

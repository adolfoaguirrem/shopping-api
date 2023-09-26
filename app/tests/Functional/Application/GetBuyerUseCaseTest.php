<?php
namespace App\Tests\Functional\Application;

use App\Domain\Buyer\Buyer;
use PHPUnit\Framework\TestCase;
use App\Domain\Buyer\ValueObject\BuyerName;
use App\Application\Interfaces\BuyerInterface;
use App\Application\UseCases\GetBuyerUseCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetBuyerUseCaseTest extends TestCase
{
    public function test_execute_with_valid_buyer()
    {
        // Create a simulated buyer
        $buyerId = 1;

        $buyer = new Buyer(
            new BuyerName('John Doe')
        );

        // Create a mock repository object
        $buyerRepository = $this->createMock(BuyerInterface::class);

        // Set up the behavior of the mock repository
        $buyerRepository->expects($this->once())
            ->method('findById')
            ->with($buyerId)
            ->willReturn($buyer);

        // Create an instance of GetBuyerUseCase with the mock repository
        $useCase = new GetBuyerUseCase($buyerRepository);

        // Execute the execute method
        $result = $useCase->execute($buyerId);

        // Verify that the result is the same as the simulated buyer
        $this->assertSame($buyer, $result);
    }

    public function test_execute_with_invalid__buyer()
    {
        // Define a simulated buyer ID
        $buyerId = 2;

        // Create a mock repository object
        $buyerRepository = $this->createMock(BuyerInterface::class);

        // Set up the behavior of the mock repository to return null
        $buyerRepository->expects($this->once())
            ->method('findById')
            ->with($buyerId)
            ->willReturn(null);

        // Create an instance of GetBuyerUseCase with the mock repository
        $useCase = new GetBuyerUseCase($buyerRepository);

        // Execute the execute method and expect a NotFoundHttpException
        $this->expectException(NotFoundHttpException::class);
        $useCase->execute($buyerId);
    }
}

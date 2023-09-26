<?php

namespace App\Tests\Functional\Application;

use App\Domain\Buyer\Buyer;
use PHPUnit\Framework\TestCase;
use App\Application\UseCases\CreateBuyerUseCase;
use App\Infrastructure\Doctrine\Repository\DoctrineBuyerRepository;

class CreateBuyerUseCaseTest extends TestCase
{
    public function test_create_buyer_use_case()
    {
        $repository = $this->createMock(DoctrineBuyerRepository::class);
        $repository->expects($this->once())->method('save');

        $requestParams = [
            'name' => 'Buyer name'
        ];

        $createBuyer = new CreateBuyerUseCase($repository);
        $buyer = $createBuyer->execute($requestParams);

        $this->assertInstanceOf(Buyer::class, $buyer);
        $this->assertEquals('Buyer name', $buyer->getName()->value());
    }
}

<?php

namespace App\Application\UseCases;

use App\Domain\Buyer\Buyer;
use App\Domain\Buyer\ValueObject\BuyerName;
use App\Application\Interfaces\BuyerInterface;

class CreateBuyerUseCase
{
    public function __construct(private BuyerInterface $buyerRepository)
    {
    }

    public function execute($data): Buyer
    {
        $buyer = new Buyer(
            new BuyerName($data['name'])
        );

        $this->buyerRepository->save($buyer);

        return $buyer;
    }
}

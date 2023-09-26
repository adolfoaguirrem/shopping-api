<?php

namespace App\Application\UseCases;

use App\Domain\Buyer\Buyer;
use App\Application\Interfaces\BuyerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetBuyerUseCase
{

    public function __construct(private BuyerInterface $buyerRepository)
    {
    }

    public function execute(int $buyerId): Buyer
    {
        $buyer = $this->buyerRepository->findById($buyerId);

        if (is_null($buyer)) {
            return throw new NotFoundHttpException('Buyer not found');
        }

        return $buyer;
    }
}

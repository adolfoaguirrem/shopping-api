<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Cart\Cart;
use Doctrine\Persistence\ManagerRegistry;
use App\Domain\Cart\ValueObject\CartStatus;
use App\Application\Interfaces\CartInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineCartRepository extends ServiceEntityRepository implements CartInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cart::class);
    }

    public function save(Cart $cart): Cart
    {
        $this->_em->persist($cart);
        $this->_em->flush();

        return $cart;
    }

    public function findById(int $id): ?Cart
    {
        return $this->find($id);
    }

    public function getOpenByBuyer(int $buyer_id): ?Cart
    {
        $cart = $this->findOneBy([
            'buyer_id' => $buyer_id,
            'status' => CartStatus::OPEN
        ]);

        return $cart;
    }

    public function update(Cart $cart): Cart
    {
        $this->_em->persist($cart);
        $this->_em->flush();

        return $cart;
    }

    /*public function delete(int $id): void
    {
        //return $this->find($id);
    }*/
}

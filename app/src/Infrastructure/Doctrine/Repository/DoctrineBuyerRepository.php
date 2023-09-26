<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Buyer\Buyer;
use Doctrine\Persistence\ManagerRegistry;
use App\Application\Interfaces\BuyerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineBuyerRepository extends ServiceEntityRepository implements BuyerInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Buyer::class);
    }

    public function save(Buyer $buyer): void
    {
        $this->_em->persist($buyer);
        $this->_em->flush();
    }

    public function findById(int $id): ?Buyer
    {
        return $this->find($id);
    }

    /**
     * Return all buyers
     *
     * @return array<string, mixed>
     */
    public function findAll(): array
    {
        $buyers = $this->_em->getRepository(Buyer::class)->findAll();
        return $buyers;
    }
}

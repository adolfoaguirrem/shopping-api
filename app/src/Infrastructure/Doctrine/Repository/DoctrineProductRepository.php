<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Product\Product;
use Doctrine\Persistence\ManagerRegistry;
use App\Application\Interfaces\ProductInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Product>
 */
class DoctrineProductRepository extends ServiceEntityRepository implements ProductInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $product): void
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }


    /**
     * Get one product
     *
     * @param string $id
     *
     * @return Product|null
     */
    public function findById(int $id): ?Product
    {
        return $this->find($id);
    }

    /**
     * Return all document
     *
     * @return array<string, mixed>
     */
    public function findAll(): array
    {
        $products = $this->_em->getRepository(Product::class)->findAll();
        return $products;
    }

}

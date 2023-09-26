<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\CartProduct\CartProduct;
use Doctrine\Persistence\ManagerRegistry;
use App\Application\Interfaces\CartProductInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class DoctrineCartProductRepository extends ServiceEntityRepository implements CartProductInterface
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartProduct::class);
    }

    public function save(CartProduct $cartProduct): CartProduct
    {
        $this->_em->persist($cartProduct);
        $this->_em->flush();

        return $cartProduct;
    }

    public function getProductsOnCart(int $cart_id): array
    {
        return $this->findBy([
            'cart_id' => $cart_id
        ]);
    }

    public function getProductOnCart(int $cart_id, int $product_id): ?CartProduct
    {
        $cartProduct = $this->findOneBy([
            'cart_id' => $cart_id,
            'product_id' => $product_id
        ]);

        return $cartProduct;
    }

    public function delete(CartProduct $cartProduct): void
    {
        $this->_em->remove($cartProduct);
        $this->_em->flush();
    }
}

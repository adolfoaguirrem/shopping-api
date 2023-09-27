<?php

namespace App\Infrastructure\Doctrine\Repository;

use App\Domain\Cart\Cart;
use App\Domain\Product\Product;
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

    public function findByCart(int $cart_id): array
    {
        return $this->findBy([
            'cart_id' => $cart_id
        ]);
    }

    public function findByCartAndProduct(Cart $cart, Product $product): ?CartProduct
    {
        $cartProduct = $this->findOneBy([
            'cart' => $cart,
            'product' => $product,
        ]);

        return $cartProduct;
    }

    public function delete(CartProduct $cartProduct): void
    {
        $this->_em->remove($cartProduct);
        $this->_em->flush();
    }
}

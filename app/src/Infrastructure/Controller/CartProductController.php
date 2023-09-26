<?php

namespace App\Infrastructure\Controller;

use Throwable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\UseCases\GetProductsOnCartUseCase;
use App\Application\UseCases\AddProductToCartUseCase;
use App\Infrastructure\Exception\ValidationException;
use App\Application\UseCases\DeleteProductOnCartUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartProductController extends AbstractController
{
    public function __construct(
        private AddProductToCartUseCase $addProductToCartUseCase,
        private GetProductsOnCartUseCase $getProductsOnCartUseCase,
        private DeleteProductOnCartUseCase $deleteProductOnCartUseCase
    ) {
    }

    #[Route('/api/carts/{cart_id}/products', name: 'cart_product_get', methods: ['GET'])]
    public function getCartProducts(int $cart_id)
    {
        $cart_products = $this->getProductsOnCartUseCase->execute($cart_id);
        return new JsonResponse(['cart' => $cart_products], JsonResponse::HTTP_OK);
    }

    #[Route('/api/carts/products', name: 'cart_product_post_one', methods: ['POST'])]
    public function addProduct(Request $request): JsonResponse
    {
        try {
            $jsonData = $request->getContent();
            $data = json_decode($jsonData, true);
            $this->addProductToCartUseCase->execute($data);

            return new JsonResponse(['message' => 'New product added to cart'], JsonResponse::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse([
                'message' => 'The product cannot be added to this cart',
                'errors' => $e instanceof ValidationException ? $e->getValidationMessages() : $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/api/carts/products', name: 'cart_product_remove_one', methods: ['DELETE'])]
    public function deleteOneCartProduct(Request $request): JsonResponse
    {
        try {
            $jsonData = $request->getContent();
            $data = json_decode($jsonData, true);
            $this->deleteProductOnCartUseCase->execute($data);

            return new JsonResponse(['message' => 'Product from cart deleted'], JsonResponse::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse([
                'message' => 'The product cannot be remove to this cart',
                'errors' => $e instanceof ValidationException ? $e->getValidationMessages() : $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}

<?php

namespace App\Infrastructure\Controller;

use Throwable;
use App\Application\UseCases\GetCartUseCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\ConfirmCartUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Application\UseCases\AddProductToCartUseCase;
use App\Infrastructure\Exception\ValidationException;
use App\Application\UseCases\DeleteProductOnCartUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    public function __construct(
        private AddProductToCartUseCase $addProductToCartUseCase,
        private GetCartUseCase $getCartUseCase,
        private DeleteProductOnCartUseCase $deleteProductOnCartUseCase,
        private ConfirmCartUseCase $confirmCartUseCase
    ) {
    }

    #[Route('/api/carts/{id}', name: 'cart_product_get', methods: ['GET'])]
    public function getCartProducts(int $id)
    {
        $cart = $this->getCartUseCase->execute($id);
        return new JsonResponse(['cart_detail' => $cart], JsonResponse::HTTP_OK);
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

    #[Route('/api/carts/{id}/confirm', name: 'cart_product_confirm', methods: ['PUT'])]
    public function confirmCartStatus(int $id): JsonResponse
    {
        try {
            $this->confirmCartUseCase->execute($id);
            return new JsonResponse(['message' => 'Cart confirmed'], JsonResponse::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse([
                'message' => 'Cart cannot be confirmed',
                'errors' => $e instanceof ValidationException ? $e->getValidationMessages() : $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}

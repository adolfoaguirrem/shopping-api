<?php

namespace App\Infrastructure\Controller;

use Throwable;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\ConfirmCartUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Exception\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    public function __construct(private ConfirmCartUseCase $confirmCartUseCase)
    {
    }

    #[Route('/api/carts', name: 'cart_get', methods: ['GET'])]
    public function getcarts()
    {
        return new JsonResponse(['carts' => []], JsonResponse::HTTP_OK);
    }

    #[Route('/api/carts/{cart_id}/confirm', name: 'cart_product_confirm', methods: ['PUT'])]
    public function confirmCartStatus(int $cart_id): JsonResponse
    {
        try {
            $this->confirmCartUseCase->execute($cart_id);
            return new JsonResponse(['message' => 'Cart confirmed'], JsonResponse::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse([
                'message' => 'Cart cannot be confirmed',
                'errors' => $e instanceof ValidationException ? $e->getValidationMessages() : $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}

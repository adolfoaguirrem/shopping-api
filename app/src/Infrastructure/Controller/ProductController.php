<?php

namespace App\Infrastructure\Controller;

use Throwable;
use App\Application\Request\ProductRequest;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\CreateProductUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Exception\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    public function __construct(private CreateProductUseCase $createProductUseCase)
    {
    }

    #[Route('/api/products', name: 'products_get', methods: ['GET'])]
    public function getProducts()
    {
        return new JsonResponse(['products' => []], JsonResponse::HTTP_OK);
    }

    #[Route('/api/products', name: 'products_post', methods: ['POST'])]
    public function createProduct(ProductRequest $request): JsonResponse
    {
        try {
            $request->validate();
            $data = $request->getContent();
            $this->createProductUseCase->execute($data);

            return new JsonResponse(['message' => 'Product created'], JsonResponse::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse([
                'message' => 'Product cannot be created',
                'errors' => $e instanceof ValidationException ? $e->getValidationMessages() : $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}

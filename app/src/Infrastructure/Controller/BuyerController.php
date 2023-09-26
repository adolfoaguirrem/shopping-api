<?php

namespace App\Infrastructure\Controller;

use Throwable;
use App\Application\Request\BuyerRequest;
use Symfony\Component\Routing\Annotation\Route;
use App\Application\UseCases\CreateBuyerUseCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Infrastructure\Exception\ValidationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BuyerController extends AbstractController
{
    public function __construct(private CreateBuyerUseCase $createBuyerUseCase)
    {
    }

    #[Route('/api/buyers', name: 'buyers_get', methods: ['GET'])]
    public function index()
    {
        return new JsonResponse(['buyers' => []], JsonResponse::HTTP_OK);
    }

    #[Route('/api/buyers', name: 'buyers_post', methods: ['POST'])]
    public function createBuyer(BuyerRequest $request): JsonResponse
    {
        try {
            $request->validate();
            $data = $request->getContent();
            $this->createBuyerUseCase->execute($data);

            return new JsonResponse(['message' => 'Buyer created'], JsonResponse::HTTP_OK);
        } catch (Throwable $e) {
            return new JsonResponse([
                'message' => 'Buyer cannot be created',
                'errors' => $e instanceof ValidationException ? $e->getValidationMessages() : $e->getMessage()
            ], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
}

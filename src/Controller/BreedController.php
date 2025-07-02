<?php

namespace App\Controller;

use App\Service\BreedService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class BreedController extends AbstractController
{
    public function __construct(private readonly BreedService $breedService)
    {
    }

    #[Route('/breeds', name: 'app_get_breeds', methods: ['GET'])]
    public function getBreeds(Request $request): Response
    {
        $data = $this->breedService->getBreeds($request);

        return $this->json($data);
    }
}

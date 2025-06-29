<?php

namespace App\Controller;

use App\Service\PetService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PetController extends AbstractController
{
    public function __construct(private readonly PetService $petService){}

    #[Route('/', name: 'app_pet')]
    public function index(): Response
    {
        $form = $this->petService->getForm();
        return $this->render('pet/index.html.twig', [
            'form' => $form,
        ]);
    }
}

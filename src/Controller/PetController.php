<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PetController extends AbstractController
{
    #[Route('/', name: 'app_pet')]
    public function index(): Response
    {
        return $this->render('pet/index.html.twig', [
            'controller_name' => 'PetController',
        ]);
    }
}

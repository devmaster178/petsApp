<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Form\PetForm;
use App\Service\PetService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PetController extends AbstractController
{
    public function __construct(private readonly PetService $petService){}

    #[Route('/', name: 'app_pet')]
    public function index(): Response
    {
        return $this->render('pet/index.html.twig');
    }

    #[Route('/api/pet/save', name: 'save_pet', methods: ['POST'])]
    public function savePet(Request $request, EntityManagerInterface $entityManager){
        $pet = new Pet();
        $form = $this->createForm(PetForm::class, $pet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pet);
            $entityManager->flush();

            return $this->redirectToRoute('app_pet', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('pet/index.html.twig', [
            'pet' => $pet,
            'form' => $form,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Pet;
use App\Form\PetFormType;
use App\Service\PetService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PetController extends AbstractController
{
    public function __construct(private PetService $petService){}

    #[Route('/', name: 'app_pet')]
    public function index(): Response
    {
        return $this->render('pet/register.html.twig');
    }

    #[Route('/api/pet/save', name: 'save_pet', methods: ['POST'])]
    public function registerPet(Request $request, EntityManagerInterface $entityManager): RedirectResponse|Response
    {
        $pet = new Pet();
        $form = $this->createForm(PetFormType::class, $pet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->petService->registerPet($request, $pet);
            return $this->redirectToRoute('app_get_breeds', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('pet/register_feedback.html.twig', [
            'pet' => $pet,
            'form' => $form,
        ]);
    }
}

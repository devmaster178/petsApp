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
    public function register(): Response
    {
        return $this->render('pet/register.html.twig');
    }

    #[Route('/pet/summary', name: 'app_pet_summary', methods: ['GET'])]
    public function summary(): Response
    {
        $data = $this->petService->summary();
        return $this->render('pet/index.html.twig', $data);
    }

    #[Route('/pet/save', name: 'save_pet', methods: ['POST'])]
    public function save(Request $request): RedirectResponse|Response
    {
        $pet = new Pet();
        $form = $this->createForm(PetFormType::class, $pet);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->petService->save($request, $pet);
            $this->addFlash('success', 'Pet registered successfully!');
            return $this->redirectToRoute('app_pet_summary', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('pet/register_feedback.html.twig', [
            'pet' => $pet,
            'form' => $form,
        ]);
    }
}

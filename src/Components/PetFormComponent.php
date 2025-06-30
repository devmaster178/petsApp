<?php
namespace App\Components;

use App\Entity\Pet;
use App\Form\PetFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Component\Form\FormInterface;

#[AsLiveComponent('pet_form_component')]
class PetFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;

    #[LiveProp]
    public bool $isSuccessful = false;
    #[LiveProp]
    public ?Pet $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(PetFormType::class, $this->initialFormData);
    }


//    #[LiveAction]
//    public function save(EntityManagerInterface $entityManager): RedirectResponse
//    {
//        // Submit the form! If validation fails, an exception is thrown
//        // and the component is automatically re-rendered with the errors
//        $this->submitForm();
//
//        /** @var Pet $post */
//        $post = $this->getForm()->getData();
//        $entityManager->persist($post);
//        $entityManager->flush();
//
//        $this->addFlash('success', 'Post saved!');
//
//        return $this->redirectToRoute('app_get_breeds');
//    }
}

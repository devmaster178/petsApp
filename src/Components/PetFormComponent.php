<?php
namespace App\Components;

use App\Entity\Pet;
use App\Form\PetFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Component\Form\FormInterface;

#[AsLiveComponent('pet_form_component')]
class PetFormComponent extends AbstractController
{
    use DefaultActionTrait;
    use ComponentWithFormTrait;
    #[LiveProp(writable: true)]
    public ?Pet $initialFormData = null;

    protected function instantiateForm(): FormInterface
    {
        return $this->createForm(PetFormType::class, $this->initialFormData);
    }
}

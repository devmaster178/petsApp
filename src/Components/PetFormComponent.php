<?php
// src/Components/DynamicFormComponent.php
namespace App\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

#[AsLiveComponent('pet_form')]
class PetFormComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $selectedType = '';

    #[LiveProp(writable: true)]
    public array $formData = [];

    public function getForm(): FormInterface
    {
        $formBuilder = $this->createFormBuilder($this->formData);

        $formBuilder->add('type', ChoiceType::class, [
            'choices' => [
                'General Inquiry' => 'general',
                'Support Request' => 'support',
                'Billing Question' => 'billing',
            ],
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);

        $formBuilder->add('name', TextType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 2]),
            ],
        ]);

        $formBuilder->add('email', EmailType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email(),
            ],
        ]);

        if ($this->selectedType === 'support') {
            $formBuilder->add('product', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                ],
            ]);
        }

        $formBuilder->add('message', TextareaType::class, [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Length(['min' => 10]),
            ],
        ]);

        return $formBuilder->getForm();
    }

    #[LiveAction]
    public function save()
    {
        $form = $this->getForm();
        $form->submit($this->formData);

        if ($form->isValid()) {
            // Process valid form
            // You can add flash message or redirect here
        }

        // Component will re-render with errors if any
    }
}

<?php
namespace App\Form;

use App\Entity\Breed;
use App\Entity\Pet;
use App\Entity\PetType;
use App\Enum\BreedChoiceEnum;
use App\Enum\GenderEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Positive;

class PetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5]),
                ],
            ])
            ->add('type', EntityType::class, [
                'class' => PetType::class,
                'choice_label' => 'name',
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'placeholder' => 'Select a pet type',
            ])
            ->add('breed', EntityType::class, [
                'class' => Breed::class,
                'mapped' => false,
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'choices' => [],
                'attr' => ['id' => 'breed-dropdown'],
            ])
            ->add('breed_choice', EnumType::class, [ //depends on if can't find it was breed
                'class' => BreedChoiceEnum::class,
                'choice_label' => function (BreedChoiceEnum $choice) {
                    return $choice->getLabel();
                },
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null
            ])
            ->add('breed_other', TextType::class,[ //depends on mix breed_choice
                'required' => false
            ])
            ->add('sex', EnumType::class, [
                'class' => GenderEnum::class,
                'choice_label' => function (GenderEnum $choice) {
                    return $choice->getLabel();
                },
                'expanded' => true,
                'multiple' => false,
                'required' => false,
                'placeholder' => null
            ])
            ->add('age',NumberType::class,[ //depends on if dob is not known
                'required' => false,
                'constraints' => [
                    new Positive(),
                    new LessThanOrEqual(100),
                ],
            ])
            ->add('date_of_birth', DateType::class, [ //depends on if dob is known
                'widget' => 'choice',
                'format' => 'yyyy-MM-dd',
                'years' => range(date('Y') - 100, date('Y')),
                'months' => $this->getMonths(),
                'placeholder' => [
                    'year' => 'yyyy',
                    'month' => 'Select',
                    'day' => 'dd'
                ],
                'choice_translation_domain' => true,
                'by_reference' => false,
            ]);

        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            dd($data);
            $breed = $data['breed'] ?? null;

            if($breed == 0){
                $form->add('breed_choice', EnumType::class, [
                    'class' => BreedChoiceEnum::class,
                    'choice_label' => function (BreedChoiceEnum $choice) {
                        return $choice->getLabel();
                    },
                    'expanded' => true,
                    'multiple' => false,
                    'required' => true
                ]);
            }
        });
    }

    private function getMonths(): array
    {
        $months = [];
        foreach (range(1, 12) as $month) {
            $monthName = \DateTime::createFromFormat('!m', $month)->format('M');
            $months[$monthName] = $month;
        }
        return $months;
    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
        ]);
    }


}

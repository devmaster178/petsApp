<?php
namespace App\Form;

use App\Entity\Breed;
use App\Entity\Pet;
use App\Entity\PetType;
use App\Enum\BreedChoiceEnum;
use App\Enum\GenderEnum;
use App\Enum\HasDobInformationEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;


class PetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('type', EntityType::class, [
                'class' => PetType::class,
                'choice_label' => 'name',
                'placeholder' => 'Select a pet type',
            ])
            ->add('breed', EntityType::class, [
                    'class' => Breed::class,
                    'choice_label' => 'name',
                    'placeholder' => 'Choose a breed'
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
            ->add('has_dob_information', EnumType::class, [
                    'class' => HasDobInformationEnum::class,
                    'choice_label' => function (HasDobInformationEnum $choice) {
                        return $choice->getLabel();
                    },
                    'expanded' => true,
                    'multiple' => false,
                    'required' => false,
                    'placeholder' => null,
                    'data' => HasDobInformationEnum::YES
            ])
            ->add('age', ChoiceType::class, [
                'required' => false,
                'choices' => array_combine(range(1, 20), range(1, 20)),
                'placeholder' => 'Select age',
            ])
            ->add('date_of_birth', DateType::class, [
                'widget' => 'choice',
                'format' => 'yyyy-MM-dd',
                'years' => range(date('Y') - 100, date('Y')),
                'placeholder' => [
                    'year' => 'yyyy',
                    'month' => 'Select',
                    'day' => 'dd'
                ],
                'choice_translation_domain' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pet::class,
        ]);
    }


}

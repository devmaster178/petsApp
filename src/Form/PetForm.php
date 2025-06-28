<?php
namespace App\Form;

// src/Form/PostType.php
namespace App\Form;

use App\Entity\Post;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class PetForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Article' => 'article',
                    'Video' => 'video',
                    'Link' => 'link',
                ],
                'constraints' => [
                    new Assert\NotBlank(),
                ],
                'placeholder' => 'Select a post type',
            ])
            ->add('title', null, [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 5]),
                ],
            ])
            ->add('content', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'groups' => ['article'], // Only validate when type is article
                    ]),
                ],
            ])
            ->add('videoUrl', null, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'groups' => ['video'],
                    ]),
                    new Assert\Url([
                        'groups' => ['video'],
                    ]),
                ],
                'label' => 'Video URL',
            ])
            ->add('externalUrl', UrlType::class, [
                'required' => false,
                'constraints' => [
                    new Assert\NotBlank([
                        'groups' => ['link'],
                    ]),
                ],
                'label' => 'Link URL',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
//            'validation_groups' => function ($form) {
//                $data = $form->getData();
//                $groups = ['Default'];
//
//                if ($data && $data->getType()) {
//                    $groups[] = $data->getType();
//                }
//
//                return $groups;
//            },
        ]);
    }
}

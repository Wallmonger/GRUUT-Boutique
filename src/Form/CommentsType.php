<?php

namespace App\Form;

use App\Entity\Comments;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
            // ->add('username', TypeTextType::class, [
            //     'label' => 'Votre nom',
            //     'attr' => [
            //         'class' => 'form-control'
            //     ]
            // ])
            ->add('content', TextareaType::class, [
                'label' => 'votre commentaire',
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 255
                ]),
            ])
            ->add('rating', ChoiceType::class, [
                'data' => 0,
                'expanded' => true,
                'multiple' => false,
                'choices' => [
                    '0' => 0,
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                ],
                'required' => false,
                'attr' => [
                    'class' => 'text-white'
                ],
                
                
            ])
            ->add('parentid', HiddenType::class, [
                'mapped' => false,
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-grutt w-100'
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}

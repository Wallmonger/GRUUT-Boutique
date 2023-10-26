<?php

namespace App\Form;

use App\Classe\Search;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('price', RangeType::class, [
                'label' => 'Price',
                'attr' => [
                    'min' => 100,
                    'max' => 350000
                ]
            ])
            ->add('color', ChoiceType::class, [
                'label' => 'Couleur',
                'multiple' => true,
                'expanded' => true,
                'choices' => [
                    'DarkBrown' => 'DarkBrown',
                    'Brown' => 'Brown',
                    'Orange' => 'Orange',
                    'LightOrange' => 'LightOrange',
                    'Grey' => 'Grey'
                ]
            ])
            ->add('style', ChoiceType::class, [
                'label' => 'Style',
                'multiple' => false,
                'expanded' => true,
                'required' => false,
                'choices' => [
                    'Moderne'=>'Moderne',
                    'Traditionnel'=>'Traditionnel',
                    'Unique'=>'Unique',    
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}

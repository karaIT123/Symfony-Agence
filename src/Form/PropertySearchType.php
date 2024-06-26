<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\PropertySearch;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertySearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('maxPrice',IntegerType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' =>  'Budget maximal'
                ]
            ])
            ->add('minSurface',IntegerType::class,[
                'required' => false,
                'label' => false,
                'attr' => [
                    'placeholder' =>  'Surface minimale'
                ]
            ])
            ->add('options',EntityType::class,[
                'required' => false,
                'label' => false,
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'placeholder' => 'Options requis'
            ])
           /* ->add('submit',SubmitType::class,[
                'label' => 'rechercher'
            ])*/
        ;
    }

    public function getBlockPrefix()
    {
        return '';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PropertySearch::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}

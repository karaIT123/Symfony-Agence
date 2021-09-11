<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('surface')
            ->add('rooms')
            ->add('bedrooms')
            ->add('floor')
            ->add('price')
            ->add('heat',ChoiceType::class, [
                'choices' => $this->getChoices()
            ])
            ->add('city')
            ->add('postal_code')
            ->add('sold')
            #->add('created_at', null, [
            #'label' => 'Créer le'])
            ->add('address')
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
            'translation_domain' => 'forms'
        ]);
    }

    /**
     * @return array
     */
    private function getChoices(): array
    {
        $choices = Property::HEAT;
        $output = [];
        foreach($choices as $key => $value)
        {
            $output[$value] = $key;
        }
        return $output;
    }
}

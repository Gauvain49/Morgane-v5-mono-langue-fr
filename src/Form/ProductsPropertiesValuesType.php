<?php

namespace App\Form;

use App\Entity\MgProductsProperties;
use App\Entity\MgProperties;
use App\Entity\MgPropertiesValues;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsPropertiesValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('property', EntityType::class, [
                'label' => 'Propriété',
                'class' => MgProperties::class,
                'choice_label' => 'name'
            ])
            ->add('property_value', EntityType::class, [
                'label' => 'Valeur prédéfinie',
                'class' => MgPropertiesValues::class,
                'choice_label' => 'value',
                'choice_attr' =>  function($property, $key, $value) {
                    return ['data-role' => $property->getProperty()->getId()];
                },
                'required' => false
            ])
            ->add('custom', TextType::class, [
                'label' => 'Valeur personnalisée',
                'required' => false
            ])
            //->add('product')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgProductsProperties::class,
        ]);
    }
}

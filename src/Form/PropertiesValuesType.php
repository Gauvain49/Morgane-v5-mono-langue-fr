<?php

namespace App\Form;

use App\Entity\MgProperties;
use App\Entity\MgPropertiesValues;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertiesValuesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('property', EntityType::class, [
                'label' => 'Propriété',
                'class' => MgProperties::class,
                'choice_label' => 'name'
            ])
            ->add('value', TextType::class, [
                'label' => 'Valeur'
            ])
            //->add('product')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgPropertiesValues::class,
        ]);
    }
}

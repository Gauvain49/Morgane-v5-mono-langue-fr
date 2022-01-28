<?php

namespace App\Form;

use App\Entity\MgCarriers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CarriersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('carrier_name')
            ->add('carrier_description')
            ->add('carrier_active')
            ->add('carrier_default')
            ->add('carrier_logo')
            ->add('delay')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgCarriers::class,
        ]);
    }
}

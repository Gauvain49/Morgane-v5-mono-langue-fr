<?php

namespace App\Form;

use App\Entity\MgProducts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductsDiscountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('discount', TextType::class, [
                'label' => 'Réduction à appliquer',
                'required' => true
            ])
            ->add('discount_type', ChoiceType::class, [
                'choices' => [
                    'EUR' => 'amount',
                    '%' => 'percent'
                ],
                'label' => 'Type de réduction'
            ])
            ->add('discount_on_taxe', ChoiceType::class, [
                'choices' => [
                    'TTC' => true,
                    'HT' => false
                ],
                'label' => 'sur HT ou TTC'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgProducts::class,
        ]);
    }
}

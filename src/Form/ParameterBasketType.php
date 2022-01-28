<?php

namespace App\Form;

use App\Entity\MgParameterBasket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ParameterBasketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('qty_min_cart', IntegerType::class, [
                'label' => 'Quantité minimum pour valider le panier',
                //'empty_data' => 0,
                'required' => false
            ])
            ->add('amount_min_cart', MoneyType::class, [
                'label' => 'Montant minimum de commande pour valider le panier',
                'required' => false
            ])
            ->add('majority_required', CheckboxType::class, [
                'label' => 'La majorité est requise pour commander sur le site',
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-offstyle' => 'danger',
                    'data-style' => 'btn-round',
                    'data-on' => 'Oui',
                    'data-off' => 'Non'
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgParameterBasket::class,
        ]);
    }
}

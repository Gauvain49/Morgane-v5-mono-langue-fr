<?php

namespace App\Form;

use App\Entity\MgTaxes;
use App\Entity\MgProducts;
use Doctrine\ORM\EntityRepository;
use App\Form\ProductsNumericalsType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductsDownloadableType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('productsNumericals', CollectionType::class, [
                'label' => false,
                'entry_type' => ProductsNumericalsType::class,
                'allow_add' => false
            ])
            ->add('selling_price', MoneyType::class, [
                'label' => 'Prix de vente HT'
            ])
            ->add('taxe', EntityType::class, [
                'class' => MgTaxes::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.taxe_rate', 'DESC');
                },
                'choice_label' => 'taxe_rate',
                'choice_attr' => function($choiceValue, $key, $value) {
                        // adds a class like attending_yes, attending_no, etc
                        return ['data-role' => $choiceValue->getTaxeRate()];
                    }
            ])
            ->add('selling_price_all_taxes', MoneyType::class, [
                'label' => 'Prix de vente TTC',
            ])
            ->add('offline', CheckboxType::class, [
                'label' => 'Activer',
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'danger',
                    'data-offstyle' => 'success',
                    'data-style' => 'btn-round',
                    'data-on' => 'Non',
                    'data-off' => 'Oui'
                ],
                'required' => false
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

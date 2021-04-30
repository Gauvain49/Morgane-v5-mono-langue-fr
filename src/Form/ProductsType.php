<?php

namespace App\Form;

use App\Entity\MgCategories;
use App\Entity\MgProducts;
use App\Entity\MgSuppliers;
use App\Entity\MgTaxes;
use App\Form\ProductsPropertiesValuesType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom'
            ])
            ->add('reference', TextType::class, [
                'label' => 'Référence',
                'required' => false
            ])
            ->add('summary', TextareaType::class, [
                'label' => 'Description courte',
                'required' => false,
                'attr' => [
                    'class => editor'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
            ])
            ->add('purshasing_price', MoneyType::class, [
                'label' => 'Prix d\'achat',
                'required' => false
            ])
            ->add('selling_price', MoneyType::class, [
                'label' => 'Prix de vente HT',
            ])
            ->add('selling_price_all_taxes', MoneyType::class, [
                'label' => 'Prix de vente TTC',
            ])
            ->add('sales_unit', IntegerType::class, [
                'label' => 'Unité de vente',
                'attr' => [
                    'placeholder' => 1
                ],
                'data' => is_null($options['data']->getSalesUnit()) ? 1 : $options['data']->getSalesUnit()
            ])
           ->add('categories', EntityType::class, [
                'class' => MgCategories::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                            //->join('c.contents', 'l')
                            //->addSelect('l')
                            //->where('l.lang = 1')
                            ->where('c.type = :type')
                            ->orderBy('c.position', 'ASC')
                            ->setParameter('type', 'product');
                },
                'choice_label' => 'name',
                'choice_attr' => function($categories, $key, $value) {
                    if ($categories->getLevel() > 0) {
                        return ['style' => [
                                    'padding-left' => "{$categories->getLevel()}5px"
                                ]
                            ];
                    }
                    return [];
                },
                'expanded' => true,
                'multiple' => true,
                'required' => false
            ])
            ->add('min_quantity', IntegerType::class, [
                'label' => 'Minimum commandable',
                'attr' => [
                    'placeholder' => 1
                ],
                'data' => is_null($options['data']->getMinQuantity()) ? 1 : $options['data']->getMinQuantity()
            ])
            ->add('max_quantity', IntegerType::class, [
                'label' => 'Maximum commandable',
                'required' => false
            ])
            /*->add('bulk_quantity', IntegerType::class, [
                'label' => 'Commande en vrac de',
                'required' => false,
                'help' => 'Attention ! Le vrac peut compliquer la gestion panier pour le client. A utiliser avec prudence.'
            ])*/
            /*->add('discount')
            ->add('discount_type')
            ->add('discount_on_taxe')*/
            ->add('stock_management', CheckboxType::class, [
                'label' => 'Gérer les stocks',
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
            /*->add('stock_quantity')
            ->add('sell_out_of_stock')
            ->add('stock_alert')*/
            ->add('pre_order', CheckboxType::class, [
                'label' => 'Précommande autorisée',
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
            ->add('date_available', DateTimeType::class, [
                'label' => 'Date de disponibilité',
                'format' => 'dd-MM-yyyy',
                'view_timezone' => 'Europe/Paris',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
                'help' => 'Date à laquelle le produit est disponible à la vente.',
                //'date_widget' => 'single_text',
                //'time_widget' => 'single_text',
                'html5' => false
            ])
            ->add('date_publish', DateTimeType::class, [
                'label' => 'Date de publication',
                'format' => 'dd-MM-yyyy',
                'view_timezone' => 'Europe/Paris',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false,
                'help' => 'Date à laquelle le produit apparaît dans le catalogue.',
                //'date_widget' => 'single_text',
                //'time_widget' => 'single_text',
                'html5' => false
            ])
            ->add('offline', CheckboxType::class, [
                'label' => 'Mettre hors ligne',
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
            ->add('taxe', EntityType::class, [
                'class' => MgTaxes::class,
                /*'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('t')
                        ->orderBy('t.taxe_rate', 'DESC');
                },*/
                'choice_label' => 'taxe_name',
                'choice_attr' => function($choiceValue, $key, $value) {
                    // adds a class like attending_yes, attending_no, etc
                    return ['data-role' => $choiceValue->getTaxeRate()];
                }
            ])
            ->add('supplier', EntityType::class, [
                'label' => 'Fournisseur',
                'required' => false,
                'class' => MgSuppliers::class,
                /*'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.supplier_name', 'DESC');
                },*/
                'choice_label' => 'supplier_name'
            ])
            ->add('productsProperties', CollectionType::class, [
                'label' => false,
                'label_attr' => [
                    'class' => 'properties'
                ],
                'entry_type' => ProductsPropertiesValuesType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'delete_empty' => true,
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

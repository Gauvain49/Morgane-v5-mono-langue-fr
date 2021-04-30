<?php

namespace App\Form;

use App\Entity\MgProductsNumericals;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProductsNumericalsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('is_exclusive', CheckboxType::class, [
                'label' => 'Afficher uniquement la version numérique',
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
            ->add('date_expire', DateType::class, [
                'label' => 'Date d\'expiration',
                'help' => 'Laissez le champ vide s\'il n\'y a pas d\'expiration.',
                'widget' => 'single_text',
                'required' => false
            ])
            ->add('nb_days_accessibles', IntegerType::class, [
                'label' => 'Nbre de jour disponible après commande',
                'required' => false,
                'help' => 'Laissez le champ vide s\'il n\'y a pas de limite.'
            ])
            ->add('nb_downloadable', IntegerType::class, [
                'label' => 'Nbre de téléchargement possible',
                'required' => false,
                'help' => 'Laissez le champ vide s\'il n\'y a pas de limite.'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgProductsNumericals::class,
        ]);
    }
}

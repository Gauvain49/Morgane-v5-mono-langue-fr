<?php

namespace App\Form;

use App\Entity\MgCategories;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoriesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom']
            )
            ->add('parent', ChoiceType::class, [
                'choices' => $options['checkbox'],
                'choice_value' => function($categories) {
                    if(!is_null($categories)) {
                        return $categories->getId();
                    }
                },
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false
            ])
            //->add('slug')
            ->add('active', CheckboxType::class, [
                'label' => 'Afficher',
                'attr' => [
                    'data-toggle' => 'toggle',
                    'data-onstyle' => 'success',
                    'data-offstyle' => 'danger',
                    'data-style' => 'btn-round',
                    'data-on' => 'Oui',
                    'data-off' => 'Non'
                ],
                'data' => is_null($options['data']->getActive()) ? true : $options['data']->getActive(),
                'required' => false
            ])
            ->add('force_display', CheckboxType::class, [
                'label' => 'Forcer l\'affichage si vide',
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
            //->add('type')
            //->add('date_creat')
            //->add('date_up')
            //->add('level')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgCategories::class,
        ])
        ->setRequired('checkbox');;
    }
}

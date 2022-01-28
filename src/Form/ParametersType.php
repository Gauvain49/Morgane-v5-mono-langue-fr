<?php

namespace App\Form;

use App\Entity\MgParameters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Nom du site'
            ])
            ->add('slogan', TextType::class, [
                'label' => 'Slogan/Devise...',
                'required' => false
            ])
            ->add('seo_description', TextType::class, [
                'label' => 'Description',
                'help' => 'Renseigne la balise meta \'description\' utilisé par certain moteur de recherche pour présenter brièvement le site.',
                'required' => false
            ])
            ->add('email_contact', EmailType::class, [
                'label' => 'Email de contact'
            ])
            ->add('email_order', EmailType::class, [
                'label' => 'Emailde réception des commandes'
            ])
            ->add('logo', TextType::class, [
                'label' => 'Votre logo...',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgParameters::class,
        ]);
    }
}

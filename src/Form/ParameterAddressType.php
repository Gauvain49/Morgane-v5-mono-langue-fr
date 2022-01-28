<?php

namespace App\Form;

use App\Entity\MgParameterAddresses;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParameterAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('address_title', TextType::class, [
                'label' => 'Intitulé de l\'adresse'
            ])
            ->add('address', TextareaType::class, [
                'label' => 'Addresse'])
            ->add('zipcode', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['style' => 'width: 100px;']
                ])
            ->add('town', TextType::class, [
                'label' => 'Ville'])
            ->add('phone', TelType::class, [
                'label' => 'Téléphone fixe',
                'attr' => ['style' => 'width: 200px;'],
                'required' => false])
            ->add('mobile', TelType::class, [
                'label' => 'Téléphone mobile',
                'attr' => ['style' => 'width: 200px;'],
                'required' => false])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => false])
            ->add('opening_time', TextareaType::class, [
                'label' => 'horaires d\'ouvertures',
                'required' => false])
            ->add('map', TextareaType::class, [
                'label' => 'Code Carte interactive (Ex. Google Map)',
                'required' => false])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgParameterAddresses::class,
        ]);
    }
}

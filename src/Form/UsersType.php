<?php

namespace App\Form;

use App\Entity\MgUsers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('roles')
            ->add('password')
            ->add('lastname')
            ->add('firstname')
            ->add('email')
            ->add('date_creat')
            ->add('active')
            //->add('customer_compagny')
            //->add('customer_birthday')
            //->add('customer_notes')
            //->add('gender')
            //->add('customer_group')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgUsers::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\MgGenders;
use App\Entity\MgUsers;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CustomersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('username')
            //->add('roles')
            ->add('gender', EntityType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-check-inline'
                ],
                'class' => MgGenders::class,
                'choice_label' => 'short_gender',
                'expanded' => true,
                'multiple' => false
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'style' => 'max-width: 500px'
                ],
                'constraints' => new Length(2, 2),
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'style' => 'max-width: 500px'
                ]
            ])
            ->add('username', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'style' => 'max-width: 500px'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Vous n\'avez pas saisie le même mot de passe.',
                'first_options' => ['label' => 'Mot de passe', 'attr' => ['style' => 'max-width: 500px'], 'help' => 'Votre mot de passe doit comporter au moins huit caractères, dont des lettres majuscules et minuscules, un chiffre et un symbole (@ # $ %).'],
                'second_options' => ['label' => 'Confirmez le mot de passe', 'invalid_message' => 'Vous n\'avez pas saisie le même mot de passe.', 'attr' => ['style' => 'max-width: 500px']]
            ])
            //->add('date_creat')
            //->add('active')
            //->add('customer_compagny')
            //->add('customer_birthday')
            //->add('customer_notes')
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

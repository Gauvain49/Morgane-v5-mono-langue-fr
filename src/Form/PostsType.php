<?php

namespace App\Form;

use App\Entity\MgPosts;
use App\Entity\MgRelationPages;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Saisissez votre titre'
                ]
            ])
            ->add('content', CKEditorType::class, [
                'label' => 'Contenu',
                'config' => ['toolbar' => 'my_toolbar_1'],
                'required' => false
            ])
            ->add('date_publish', DateTimeType::class, [
                'label' => 'Date de publication',
                'view_timezone' => 'Europe/Paris',
                'help' => 'Laisser les champs vides s\'il n\'y a pas de date programmée.',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false
            ])
            ->add('date_expire', DateTimeType::class, [
                'label' => 'Date d\'expiration',
                //'format' => 'dd-MM-yyyy',
                'view_timezone' => 'Europe/Paris',
                'help' => 'Laisser les champs vides s\'il n\'y a pas de date programmée.',
                'date_widget' => 'single_text',
                'time_widget' => 'single_text',
                'required' => false
                ]
            )
            ->add('comment', CheckboxType::class, [
                'label' => 'Autoriser les commentaires',
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
            //->add('status')
            //->add('sort')
            //->add('mime_type')
            //->add('media_sizes')
            //->add('slug')
            //->add('filename')
            //->add('date_creat')
            //->add('date_update')
        ;
        if ($options['role'] == 'page') {
            $builder
                ->add('parent', ChoiceType::class, [
                    'label' => 'Page parente',
                    'choices' => $options['checkbox'],
                    'choice_value' => function($categories) {
                        if(!is_null($categories)) {
                            return $categories->getId();
                        }
                    },
                    'multiple' => false,
                    'expanded' => false,
                    'required' => false
                    ]
                )
                ->add('relationPages', EntityType::class, [
                    'class' => MgRelationPages::class,
                    /*'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                //->join('c.contents', 'l')
                                //->addSelect('l')
                                //->where('l.lang = 1')
                                ->where('c.type = :type')
                                ->orderBy('c.position', 'ASC')
                                ->setParameter('type', 'post');
                    },*/
                    'choice_label' => 'name',
                    'expanded' => false,
                    'multiple' => false,
                    'required' => false
                ])
            ;
        } else {
            $builder
                ->add('categories', EntityType::class, [
                    'class' => MgCategories::class,
                    'query_builder' => function(EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                                //->join('c.contents', 'l')
                                //->addSelect('l')
                                //->where('l.lang = 1')
                                ->where('c.type = :type')
                                ->orderBy('c.position', 'ASC')
                                ->setParameter('type', 'post');
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
                    ]
                )
                ->add('illustration', CKEditorType::class, [
                'label' => 'Image d\'illustration',
                'config' => ['toolbar' => 'toolbar_illustration'],
                //'config_name' => 'admin_config',
                //'input_sync' => true,
                'required' => false])
            ;
        }
        $builder
            ->add('post_draft', SubmitType::class, [
                'label' => 'Enregistrer comme brouillon',
                'attr' => ['class' => 'btn btn-primary btn-border'
                ]
            ])
            ->add('post_view', SubmitType::class, [
                'label' => 'Visualiser',
                'attr' => ['class' => 'btn btn-warning'
                ]
            ])
            ->add('post_publish', SubmitType::class, [
                'label' => 'Publier',
                'attr' => ['class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MgPosts::class,
            'role' => 'page'
        ])
            ->setRequired(
                'checkbox'
            )
        ;
        $resolver->setAllowedTypes('role', 'string');
    }
}

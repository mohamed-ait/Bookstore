<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('isbn',null,[
            'label' => 'ISBN 13',
            'attr'  => ['class' => 'form-control my-3']
        ])
        ->add('titre',null,[
            'label' => 'Titre',
            'attr'  => ['class' => 'form-control my-3']
        ])
        ->add('nombre_pages',null,[
            'label' => 'Nombre de pages',
            'attr'  => ['class' => 'form-control my-3']
        ])
        ->add('date_de_parution',DateType::class,[
            'widget' => 'single_text',
            'attr' => ['class' => 'form-control my-3']
            ])
        ->add('note',DateType::class,[
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control my-3']
                ])
        ->add('autheurs',null,[
                    'attr'  => ['class' => 'form-control my-3']
                ])
        ->add('genres',null,[
                    'attr'  => ['class' => 'form-control my-3']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_prenom', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom & Prenom',
                    'class' => 'form-control'
                ]
            ])
            ->add('sexe', ChoiceType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Sexe'
                ],
                'choices'  => [
                    'Mâle' => "M",
                    'Femelle' => 'F'
                ]
            ])
            ->add('date_de_naissance', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Date de naissance'
                ],
                'widget' => 'single_text',
                'input'  => 'datetime_immutable'
            ])
            ->add('nationalite', CountryType::class, [
                'attr' => [
                    'placeholder' => 'Nationalite',
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}

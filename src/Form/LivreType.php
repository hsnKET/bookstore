<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Repository\AuteurRepository;
use Doctrine\DBAL\Types\DateImmutableType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    private int $MAX_RESULT = 10;
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('isbn', TextType::class, [
                'attr' => [
                    'placeholder' => 'ISBN de le livre',
                    'class' => 'form-control'
                ]
            ])
            ->add('titre', TextType::class, [
                'attr' => [
                    'placeholder' => 'Le titre de livre',
                    'class' => 'form-control'
                ]
            ])
            ->add('nombre_pages', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'le nombre de pages de livre',
                    'class' => 'form-control'
                ]
            ])
            ->add('date_de_parution', DateType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'attr' => [
                    'placeholder' => 'Date de parution de livre',
                    'class' => 'form-control',


                ]
            ])
            ->add('note', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Note',
                    'class' => 'form-control'
                ]
            ])
            ->add('auteurs', EntityType::class, [
                'choice_label' => 'nom_prenom', //choice nom_prenom in entity
                'class'        => Auteur::class,
                'expanded'     => false,
                'multiple'     => true,
                'by_reference' => false, //to use add set.. in search for method add set.. genre
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                        ->setMaxResults($this->MAX_RESULT)
                        ->orderBy('l.id', 'ASC');
                },
                'attr' => [
                    'class' => 'select-auteurs form-control',
                    'placeholder' => 'Les auteurs'
                ]
            ])
            ->add('genres', EntityType::class, [
                'choice_label' => 'nom',
                'class'        => Genre::class,
                'expanded'     => false,
                'multiple'     => true,
                'by_reference' => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->setMaxResults($this->MAX_RESULT)
                        ->orderBy('g.id', 'ASC');
                },
                'attr' => [
                    'class' => ' select-genres form-control',
                    'placeholder' => 'Les genres'
                ]
            ])
            ->add('image', UrlType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Le URL d\'image'
                ]
            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'La Description de livre'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}

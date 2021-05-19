<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireType extends AbstractType
{
    // La fonction suivante permet de créer un type de formulaire précis lorsque la classe StagiaireType sera appelée
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder (instanciation de la classe FormBuilderInterface, qui permet de créer un générateur de formulaire)
        // ajoute des champs au formulaires avec un nom, un type (qui correspond à une class de symfony), et d'éventuels attributs.
        $builder
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('dateNaissance', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('codePostal', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('courriel', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('sexe', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            // ->add('sessions', EntityType::class, [
            // 'att' =>[],
            //     'class' => Session::class,
            //     'choice_label' => function ($session) {
            //         return $session;
            //     },
            // ])
            ->add('envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success m-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}

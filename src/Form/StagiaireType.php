<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('dateNaissance', DateType::class, [
                'attr' => [],
                'widget' => 'single_text',
            ])
            ->add('adresse', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('codePostal', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('ville', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('courriel', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('telephone', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('sexe', TextType::class, [
                'attr' => [],
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
                'attr' => [],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formation;
use App\Entity\Stagiaire;

use App\Form\ProgrammerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateDebut', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('dateFin', DateType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('nbPlaces', IntegerType::class, [
                'attr' => [
                    // seuils minimum et maximum de valeurs numériques qu'on veut bien pouvoir rentrer
                    'min' => 0,
                    'max' => 20,
                    //**** */
                    'class' => 'form-control',
                ],
                'required' => true,
            ])
            ->add('formation', EntityType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'required' => true,
                'class' => Formation::class,
                'choice_label' => function ($formation) {
                    return $formation;
                },

            ])
            ->add('inscrit', CollectionType::class, [
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => 'Choisir un stagiaire',
                    'class' => Stagiaire::class,
                ],
                // 'multiple' => true,
                'required' => true,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
            ])

            ->add('programmeSession', CollectionType::class, [
                'label' => false,
                'entry_type' => ProgrammerType::class,
                'entry_options' => [
                    'label' => "Module et durée : ",
                    // 'attr' => [
                    //     'class' => 'form-control',
                    // ],
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required'=> true,
                
            ])
            ->add('Envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success m-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}

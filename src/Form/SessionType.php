<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formation;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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

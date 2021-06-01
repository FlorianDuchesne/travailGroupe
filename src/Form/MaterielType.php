<?php

namespace App\Form;

use App\Entity\Salle;
use App\Entity\Materiel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('denomination', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true,
            ])
            ->add('quantite', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true,
            ])
            // ->add('salle', EntityType::class, [
            //     // 'allow_add' => true,
            //     'attr' => [
            //         'class' => 'form-control'
            //     ],
            //     'class' => Salle::class
            // ])

            ->add(
                'envoyer',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-success m-3'
                    ]
                ]
            );

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Salle;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libelle', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'required' => true,
            ])
            ->add('nbPlaces', IntegerType::class, [
                'attr' => [
                    'min' => 0,
                    'max' => 20,
                    'class' => 'form-control'
                ]
            ])
            ->add(
                'envoyer',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-success m-3'
                    ],
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Salle::class,
        ]);
    }
}

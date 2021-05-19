<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Nom de la formation',
                'required' => true,
            ])
            ->add('descriptif', TextType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'label' => 'Descriptif',
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-success m-3'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}

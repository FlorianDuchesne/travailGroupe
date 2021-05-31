<?php

namespace App\Form;

use App\Entity\Salle;
use App\Entity\Session;
use Doctrine\ORM\EntityRepository;
use App\Repository\SalleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AjoutSalleToSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('salle', EntityType::class, [
                'attr' => [
                    'class' => 'form-control'
                ],
                'class' => Salle::class,
            ])
            ->add('envoyer', SubmitType::class, [
                'attr' => [
                    'class' => 'form-control'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Programmer;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ProgrammerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('module', EntityType::class, [
                'class' => Module::class,
                'attr' => [
                    'class' => 'form-control m-2'
                ],
                'label' => 'module :',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.libelle', 'ASC');
                }
            ])
            ->add('duree', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control m-2',
                    'min' => 0,
                ],
                'label' => 'durée :'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Programmer::class,
        ]);
    }
}

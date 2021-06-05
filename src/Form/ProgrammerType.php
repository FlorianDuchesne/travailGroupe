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
                // Le champ 'module' est de type Entité
                'class' => Module::class,
                // L'entité est spécifiquement Module
                'attr' => [
                    // Ses attributs CSS sont indiqués ci-dessous
                    'class' => 'form-control m-2'
                ],
                'label' => 'module :',
                // Le label du champ est "module :"
                'query_builder' => function (EntityRepository $er) {
                    // Le champ fait une requête DQL à partir du repository de l'entité (ici Module)
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.libelle', 'ASC');
                    // On retourne donc les modules ordonnées par libellé dans l'ordre ascendant.
                    //  C'est l'ordre dans lequel ils seront listés dans le champ.
                }
            ])
            ->add('duree', IntegerType::class, [
                // On ajoute un champ 'duree', de type Integer (numérique entier)
                'attr' => [
                    // On lui donne des attributs :
                    'class' => 'form-control m-2',
                    // des classes CSS (bootstrap)
                    'min' => 0,
                    // et un seuil minimal : on ne pourra pas aller en dessous de zéro.
                ],
                'label' => 'durée :'
                // on donne un label au champ
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Programmer::class,
            // On configure comme option que le data du formulaire devra instancier la classe Programmer
        ]);
    }
}

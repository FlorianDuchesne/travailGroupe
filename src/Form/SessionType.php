<?php

namespace App\Form;

use App\Entity\Salle;
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
                // On ajoute un champ 'inscrit' au formulaire, de type CollectionType.
                // Cette classe permet de gérer une collection. C'est le cas des stagiaires, 
                // qui sont sous forme de collection dans l'entité session. 
                // CollectionType nous permettra donc d'ajouter plusieurs stagiaires à la fois à la session.
                'entry_type' => EntityType::class,
                // Le type de chaque élément de la collection sera une entité
                'entry_options' => [
                    // On rentre les options voulues
                    'attr' => [
                        // On rentre les attributs du champ
                        'class' => 'form-control',
                        // On attribue une classe bootstrap au champ du formulaire
                    ],
                    'label' => 'Choisir un stagiaire : ',
                    // On lui donne un label (qui concerne tout le champ de formulaire)
                    'class' => Stagiaire::class,
                    // Et les entités de la collection seront spécifiquement de la classe Stagiaire
                ],
                'required' => true,
                // Le champ du formulaire est requis
                'allow_add' => true,
                // Il est autorisé d'ajouter plusieurs éléments à la fois à la collection
                'allow_delete' => true,
                // Il est autorisé de supprimer un élément de la collection qu'on était en train d'ajouter
                'label' => false,
                // On ne veut pas de label pour chaque entrée de la collection.
            ])

            ->add('programmeSession', CollectionType::class, [
                // là aussi, nous voulons un champ de type CollectionType
                'label' => false,
                // Il n'a pas de label
                'entry_type' => ProgrammerType::class,
                // Le type de chaque élément de la collection sera un formulaire imbriqué, ProgrammerType
                'entry_options' => [
                    // Il n'y a pas de label donné ici à chaque formulaire qui sera imbriqué
                    'label' => false,
                ],
                // on autorise plusieurs ajouts à la fois
                'allow_add' => true,
                // on autorise la suppression d'ajouts en cours
                'allow_delete' => true,
                // by_reference mis à false sert ici à cloner l'objet 
                //pour s'assurer qu'on appellera bien le setter de l'objet parent.
                // Cela nous permet donc de bien appeler les méthodes désirées, comme les getters et setters.
                'by_reference' => false,
                // le champ est requis
                'required' => true,

            ])
            ->add('salle', EntityType::class, [
                // Le champ salle est de type Entité
                'label' => false,
                // Pas de label
                'attr' => [
                    // classe bootstrap attribuée au champ
                    'class' => 'form-control'
                ],
                // L'entité est spécifiquement de la classe Salle
                'class' => Salle::class,
            ])
            ->add('Envoyer', SubmitType::class, [
                // Le champ 'Envoyé' est un bouton Submit, qui dispose de son propre type 
                // dans le form builder de Symfony
                'attr' => ['class' => 'btn btn-primary m-3'],
                // Il a les attributs CSS ci-dessus (classes bootstrap)
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // On configure comme option au formulaire que la classe du data du formulaire 
            // sera une instance de Session
            'data_class' => Session::class,
        ]);
    }
}

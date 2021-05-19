<?php

namespace App\Form;
// dans le terminal   php bin/console make:form
//                      je choisis comment le nommer
//                      je lui indique s'il se rapporte à une entité ou non
// création d'un form dédié et séparé du controller pour des raisons de performances
// également pour un code propre et lisible et avec une maintenabilité accrue.
use App\Entity\Session;
use App\Entity\Stagiaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//ci-dessus il ne faut pas oublier d'apeller la ou les class que l'on utilise comme TexteType ou DateType

class StagiaireType extends AbstractType
{
    // La fonction suivante permet de créer un type de formulaire précis lorsque la classe StagiaireType sera appelée
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder (instanciation de la classe FormBuilderInterface, qui permet de créer un générateur de formulaire)
        // ajoute des champs au formulaires avec un nom, un type (qui correspond à une class de symfony), et d'éventuels attributs.
        $builder
        // lorsque le form est crée pour une entité il récupère les élément de celle-ci pour créer les champs
        //les champs sont décris par leur class et donc les attibuts qui vont avec.
            ->add('nom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('dateNaissance', DateType::class, [
                'attr' => ['class' => 'form-control'],
                'widget' => 'single_text',
            ])
            ->add('adresse', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('codePostal', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('ville', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('courriel', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('telephone', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            ->add('sexe', TextType::class, [
                'attr' => ['class' => 'form-control'],
                'required' => true,
            ])
            // ne pas oublier le bouton submit qui n'est pas crée au moment de la création du form
            ->add('envoyer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success m-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}

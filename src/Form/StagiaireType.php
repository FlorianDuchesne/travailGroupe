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
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//ci-dessus il ne faut pas oublier d'apeller la ou les class que l'on utilise comme TexteType ou DateType

class StagiaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        // lorsque le form est crée pour une entité il récupère les élément de celle-ci pour créer les champs
        //les champs sont décris par leur class et donc les attibuts qui vont avec.
            ->add('nom', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('prenom', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('dateNaissance', DateType::class, [
                'attr' => [],
                'widget' => 'single_text',
            ])
            ->add('adresse', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('codePostal', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('ville', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('courriel', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('telephone', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            ->add('sexe', TextType::class, [
                'attr' => [],
                'required' => true,
            ])
            // ne pas oublier le bouton submit qui n'est pas crée au moment de la création du form
            ->add('envoyer', SubmitType::class, [
                'attr' => [],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Stagiaire::class,
        ]);
    }
}

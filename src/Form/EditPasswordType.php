<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class EditPasswordType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder

      ->add('oldPassword', PasswordType::class, [
        'label' => 'mot de passe actuel',
        'attr' => [
          'class' => 'form-control col-12'
        ]
      ])
      ->add('newPassword', RepeatedType::class, [
        'type' => PasswordType::class,
        'mapped' => false,
        'first_options' => array(
          'label' => 'Nouveau mot de passe', 'attr' => [
            'class' => 'form-control col-12'
          ]
        ),
        'second_options' => array('label' => 'Confirmez le nouveau mot de passe', 'attr' => [
          'class' => 'form-control col-12'
        ]),
        'invalid_message' => 'Les mots de passe ne correspondent pas !',
        'constraints' => [
          new Length([
            'min' => 6,
            'minMessage' => "Veuillez mettre plus de {{ limit }}caracteres",
            'max' => 15,
            'maxMessage' => "Veuillez mettre moins de {{ limit }} caracteres",
          ]),
        ],
      ])
      ->add('Valider', SubmitType::class, [
        'attr' => [
          'class' => 'btn btn-primary m-3'
        ]
      ]);;
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([]);
  }
}

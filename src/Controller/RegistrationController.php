<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditUserType;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class RegistrationController extends AbstractController
{


    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/delete", name="deleteProfil")
     */
    public function delete(User $user, EntityManagerInterface $manager)
    {
        $manager->remove($user);
        $manager->flush();
        return $this->redirectToRoute('app_login');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/{id}/edit", name="editProfil")
     */
    public function edit(Request $request, User $user, UserInterface $userlogged): Response
    {

        // checker id user connecté et id route et conditionner la suite (user interface ?)
        if ($user->getEmail() == $userlogged->getUsername()) {
            $form = $this->createForm(EditUserType::class, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // encode the plain password
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                // do anything else you need here, like send an email

                return $this->redirectToRoute('home');
            }
            return $this->render('registration/edit.html.twig', [
                'editUserForm' => $form->createView(),
            ]);
        } else {
            $this->addFlash('essaiHacking', 'Vous ne pouvez modifier ou supprimer que votre propre compte.');

            return $this->redirectToRoute('home');
        }
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();

        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}

// // S'il n'y a pas de stagiaire lorsque la fonction est appelée (cas de la route stagiaire_add),
// // On instancie un nouvel objet stagiaire
// if (!$stagiaire) {
//     $stagiaire = new Stagiaire();
// }
// // On crée un formulaire à partir de la classe StagiaireType et de l'objet stagiaire
// // Si l'objet stagiaire vient d'être créé, le formulaire sera vide, sinon il intégrera 
// //les informations du stagiaire
// $form = $this->createForm(StagiaireType::class, $stagiaire);

// // handleRequest sert à inspecter si le formulaire est soumis, et le cas échéant à appeler la requête
// $form->handleRequest($request);
// // Si le formulaire a été soumis et est valide…
// if ($form->isSubmitted() && $form->isValid()) {
//     // on assigne à l'objet stagiaire le data du formulaire
//     $stagiaire = $form->getData();
//     // On signale qu'on veut enregistrer l'objet stagiaire en base de données
//     $manager->persist($stagiaire);
//     // L'enregistrement s'effectue en base de données
//     $manager->flush();
//     // On se rend à la page dont le nom de route est 'stagiaire'
//     return $this->redirectToRoute('stagiaire');
// }
// // La fonction renvoie la vue twig où se situe le formulaire
// // Le formulaire créé est appelé formAddStagiaire
// // 'editMode est créé si on a un id de stagiaire
// return $this->render('stagiaire/add_edit.html.twig', [
//     'formAddStagiaire' => $form->createView(),
//     'editMode' => $stagiaire->getId() !== null
// ]);

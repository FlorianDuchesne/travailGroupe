<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        $sessions = $this->getDoctrine()
            ->getRepository(Session::class)
            ->prochainesSessions();

        return $this->render('home/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN", message="No access! Get out!")
     * @Route("/adminPanel", name="usersList")
     */

    public function adminPanel(): Response
    {
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        return $this->render('home/usersList.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("adminPanel/{id}", name="userShow")
     */
    public function show(User $user)
    {

        return $this->render('home/userShow.html.twig', [
            'user' => $user,
        ]);
    }

    // La fonction suivante n'est accessible qu'à un administrateur.
    // Elle requiert un identifiant, qui a dû être rentrée dans le chemin de la vue twig.

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/adminPanel/{id}/makeAdmin", name="makeAdmin")
     */

    // On paramètre une instance de la classe User grâce à l'identifiant de la route.

    public function makeAdmin(User $user)
    {

        // On rassemble tous les users instanciés grâce à Doctrine, qui appelle la méthode findAll du repository de la classe User,
        // De manière à les restituer dans la vue twig qu'on retournera à la fin de cette fonction

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        // On appelle la méthode setRoles de l'entité User pour définir le rôle du user paramétré comme admin

        $user->setRoles(['ROLE_ADMIN']);
        // On appelle le manager de Doctrine, qui nous permet d'interagir avec la base de donnée
        $entityManager = $this->getDoctrine()->getManager();
        // On demande au manager d'enregistrer la modification effectuée en base de données
        $entityManager->flush();
        // On retourne la vue twig qui suit, "chargée" du data 'users'.
        return $this->render('home/usersList.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/adminPanel/{id}/makeUser", name="makeUser")
     */

    public function makeUser(User $user)
    {

        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();

        $user->setRoles(['ROLE_USER']);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->flush();

        return $this->render('home/usersList.html.twig', [
            'users' => $users,
        ]);
    }
}

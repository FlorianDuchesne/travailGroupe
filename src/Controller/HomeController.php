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
            ->findAll();

        return $this->render('home/index.html.twig', [
            'sessions' => $sessions,
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
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
            'user' => $user
        ]);
    }
}

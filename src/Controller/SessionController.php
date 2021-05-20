<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{

    /**
     * @Route("/session/{id}/inscription", name="session_inscription")
     */
    public function inscription(Session $session, Request $request): Response
    {

        $form = $this->createForm(InscriptionType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stagiaire = $form->getData();
            $session->addInscrit($stagiaire);
            $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($session);
            $entityManager->flush();

            // dump($inscription);
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($inscription);
            // $entityManager->flush();

            return $this->redirectToRoute('session');
        }

        return $this->render('session/inscription.html.twig', [
            'formInscription' => $form->createView(),
            'session' => $session
        ]);
    }

    /**
     * @Route("/session/delete", name="session_delete")
     * @Route("/session/{id}/delete", name="session_delete")
     */
    public function delete(Session $session = null, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($session);
        $manager->flush();
        return $this->redirectToRoute('session');
    }

    /**
     * @Route("/session/add", name="session_add")
     * @Route("/session/{id}/edit", name="session_edit")
     */
    public function add(Session $session = null, Request $request): Response
    {
        if (!$session) {
            $session = new Session();
        }

        $form = $this->createForm(SessionType::class, $session);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('session');
        }

        return $this->render('session/add_edit.html.twig', [
            'formAddSession' => $form->createView(),
            'editMode' => $session->getId() !== null
        ]);
    }

    /**
     * @Route("/session/list", name="session")
     */
    public function index(): Response
    {
        $sessions = $this->getDoctrine()
            ->getRepository(Session::class)
            ->findAll();

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }

    /**
     * @Route("session/{id}", name="session_show")
     */
    public function show(Session $session): Response
    {
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Stagiaire;
use App\Form\SessionType;
use App\Form\InscriptionType;
use App\Form\AjoutSalleToSessionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{


    // Fonction d'attribution d'une salle à une session

    /**
     * @Route("/session/{id}/ajoutSalle", name="ajoutSalle")
     * @IsGranted("ROLE_ADMIN")
     */
    public function ajoutSalle(Session $session, Request $request)
    {
        $form = $this->createForm(AjoutSalleToSessionType::class, $session);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $session = $form->getData();
            // Si le nombre de places de la session est supérieur au nombre de places de la salle…
            if ($session->getNbPlaces() > $form->get('salle')->getData()->getNbPlaces()) {
                // on envoie un message d'erreur
                $this->addFlash('warning', 'La jauge de la salle ne peut pas contenir tout l\'effectif de la session !');
                // Et on retourne sur la page du formulaire
                return $this->render('session/ajoutSalle.html.twig', [
                    'formAddSalleToSession' => $form->createView(),
                ]);
            }
            // Sinon, on poursuit normalement
            else {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($session);
                $entityManager->flush();

                return $this->redirectToRoute('session');
            }
        }
        // Si le formulaire n'est pas soumis, on va sur le formulaire
        return $this->render('session/ajoutSalle.html.twig', [
            'formAddSalleToSession' => $form->createView(),
        ]);
    }

    // On peut supprimer ça il me semble ?…
    // /**
    //  * @Route("/session/{id}/inscription", name="session_inscription")
    //  * @IsGranted("ROLE_ADMIN")
    //  */
    // public function inscription(Session $session, Request $request): Response
    // {

    //     $form = $this->createForm(InscriptionType::class);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $stagiaire = $form->getData();
    //         $session->addInscrit($stagiaire);
    //         $entityManager = $this->getDoctrine()->getManager();
    //         // $entityManager->persist($session);
    //         $entityManager->flush();

    //         // dump($inscription);
    //         // $entityManager = $this->getDoctrine()->getManager();
    //         // $entityManager->persist($inscription);
    //         // $entityManager->flush();

    //         return $this->redirectToRoute('session');
    //     }

    //     return $this->render('session/inscription.html.twig', [
    //         'formInscription' => $form->createView(),
    //         'session' => $session
    //     ]);
    // }

    /**
     * @IsGranted("ROLE_ADMIN")
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
     * @IsGranted("ROLE_ADMIN")
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

    // On peut supprimer ça il me semble ?…

    // /**
    //  * @IsGranted("ROLE_ADMIN")
    //  * @Route("/session/addInscrit", name="inscrit_add")
    //  */
    // public function addInscrit(Session $session = null, Request $request): Response
    // {
    //     if (!$session) {
    //         $session = new Session();
    //     }

    //     $form = $this->createForm(InscriptionType::class, $session);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $session = $form->getData();

    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($session);
    //         $entityManager->flush();

    //         return $this->redirectToRoute('session');
    //     }

    //     return $this->render('session/inscription.html.twig', [
    //         'formInscription' => $form->createView(),
    //     ]);
    // }


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

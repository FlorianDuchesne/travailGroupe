<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class StagiaireController extends AbstractController
{

    /**
     * @Route("/stagiaire/delete", name="stagiaire_delete")
     * @Route("/stagiaire/{id}/delete", name="stagiaire_delete")
     */
    public function delete(Stagiaire $stagiaire = null, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($stagiaire);
        $manager->flush();
        return $this->redirectToRoute('stagiaire');
    }


    /**
     * @Route("/stagiaire/add", name="stagiaire_add")
     * @Route("/stagiaire/{id}/edit", name="stagiaire_edit")
     */
    public function add(Stagiaire $stagiaire = null, Request $request): Response
    {
        if (!$stagiaire) {
            $stagiaire = new Stagiaire();
        }

        $form = $this->createForm(StagiaireType::class, $stagiaire);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $stagiaire = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($stagiaire);
            $entityManager->flush();

            return $this->redirectToRoute('stagiaire');
        }

        return $this->render('stagiaire/add_edit.html.twig', [
            'formAddStagiaire' => $form->createView(),
            'editMode' => $stagiaire->getId() !== null
        ]);
    }

    /**
     * @Route("/stagiaire", name="stagiaire")
     */
    public function index(): Response
    {
        $stagiaires = $this->getDoctrine()
            ->getRepository(Stagiaire::class)
            ->findAll();

        return $this->render('stagiaire/index.html.twig', [
            // 'controller_name' => 'StagiaireController',
            'stagiaires' => $stagiaires
        ]);
    }

    /**
     * @Route("/{id}", name="stagiaire_show")
     */
    public function show(Stagiaire $stagiaire): Response
    {
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }
}

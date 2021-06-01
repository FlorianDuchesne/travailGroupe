<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Entity\Session;
use App\Form\SalleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SalleController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/salle/list", name="salle")
     */
    public function index()
    {
        $salles = $this->getDoctrine()
            ->getRepository(Salle::class)
            ->findAll();
        return $this->render('salle/index.html.twig', [
            'salles' => $salles
        ]);
    }



    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/salle/{id}/delete", name="salle_delete")
     */

    public function delete(Salle $salle, EntityManagerInterface $manager)
    {
        $manager->remove($salle);
        $manager->flush();
        return $this->redirectToRoute('salle');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/salle/add", name="salle_add")
     * @Route("/salle/{id}/edit", name="salle_edit")
     */

    public function add(Salle $salle = null, EntityManagerInterface $manager, Request $request)
    {
        if (!$salle) {
            $salle = new Salle();
        }
        $form = $this->createForm(SalleType::class, $salle);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $salle = $form->getData();
            $manager->persist($salle);
            $manager->flush();
            return $this->redirectToRoute('salle');
        }
        return $this->render('salle/add_edit.html.twig', [
            'formAddSalle' => $form->createView(),
            'editMode' => $salle->getId() !== null
        ]);
    }

    /**
     * @Route("salle/{id}", name="salle_show")
     */
    public function show(Salle $salle)
    {
        return $this->render('salle/show.html.twig', [
            'salle' => $salle
        ]);
    }
}

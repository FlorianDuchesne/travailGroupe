<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MaterielController extends AbstractController
{
  
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/materiel/list", name="materielList")
     */
    public function index()
    {
        $materiels = $this->getDoctrine()
            ->getRepository(Materiel::class)
            ->findAll();
        return $this->render('materiel/index.html.twig', [
            'materiels' => $materiels
        ]);
    }
    /**
    * @IsGranted("ROLE_ADMIN")
     * @Route("/materiel/add", name="materiel_add")
     * @Route("/materiel/{id}/edit", name="materiel_edit")
     */

    public function add(Materiel $materiel = null, EntityManagerInterface $manager, Request $request)
    {
        if (!$materiel) {
            $materiel = new Materiel();
        }
        $form = $this->createForm(MaterielType::class, $materiel);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $materiel = $form->getData();
            $manager->persist($materiel);
            $manager->flush();
            return $this->redirectToRoute('materielList');
        }
        return $this->render('materiel/add_edit.html.twig', [
            'formAddMateriel' => $form->createView(),
            'editMode' => $materiel->getId() !== null
        ]);
    }
    /**
    * @IsGranted("ROLE_ADMIN")
    * @Route("/materiel/{id}/delete", name="materiel_delete")
    */

    public function delete(Materiel $materiel, EntityManagerInterface $manager)
    {
        $manager->remove($materiel);
        $manager->flush();
        return $this->redirectToRoute('materielList');
    }


    /**
     * @IsGranted("ROLE_ADMIN") 
     * @Route("materiel/{id}", name="materiel_show")
     */
    public function show(Materiel $materiel)
    {
        return $this->render('materiel/show.html.twig', [
            'materiel' => $materiel
        ]);
    }

}

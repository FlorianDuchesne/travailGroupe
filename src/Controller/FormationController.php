<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class FormationController extends AbstractController
{
 
    
    
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/formation/new", name="formation_add")
     * @Route("/formation/{id}/edit", name="formation_edit")
     */
    public function new(Formation $formation = null, Request $request): Response
    {
        if(!$formation) {
            $formation = new Formation();
        }
        
        $form = $this->createForm(FormationType::class, $formation);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $formation = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($formation);
            $entityManager->flush();
            
            return $this->redirectToRoute('formation_index');
        }
        
        return $this->render('formation/add_edit.html.twig', [
            'formAddFormation' => $form->createView(),
            'editMode' => $formation->getId() !== null

            ]);
        }
        /**
     * @Route("formation/list", name="formation_index")
     */
    public function index(): Response
    {
        $formations = $this->getDoctrine()
                ->getRepository(Formation::class)
                ->findAll();
        
        return $this->render('formation/index.html.twig', [
            'formations' => $formations,
        ]);
    }


        /**
     *  @Route("formation/{id}", name="formation_show")
     */
    public function show(Formation $formation): Response 
    {
        return $this->render('formation/show.html.twig', [
            'formation' => $formation
        ]);
    }

    /**
    * @IsGranted("ROLE_ADMIN")
    * @Route("/formation/delete", name="formation_delete")
    * @Route("/formation/{id}/delete", name="formation_delete")
    */
    public function delete(Formation $formation = null, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($formation);
        $manager->flush();
        return $this->redirectToRoute('formation_index');
    }


}
<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormationController extends AbstractController
{
 
    
    
    /**
     * @Route("formation/new", name="formation_add")
     * @Route("formation/edit/{id}", name="formation_edit")
     */
    public function new(Request $request, Formation $formation = null): Response
    {
        if(!$formation){
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
        
        return $this->render('formation/new.html.twig', [
            'formAddFormation' => $form->createView(),
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
     *  @Route("/{id}", name="formation_show", methods="GET")
     */
    public function show(Formation $formation): Response {
        return $this->render('formation/show.html.twig', ['formation' => $formation]);
    }

}
<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Module;
use App\Form\CategorieType;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends AbstractController
{
    /**
     * @Route("/categorie/new", name="categorie_add")
     * @Route("/categorie/{id}/edit", name="categorie_edit")
     */
    public function new(Categorie $categorie = null, Request $request): Response
    {
        if(!$categorie) {
            $categorie = new Categorie();
        }
        
        $form = $this->createForm(CategorieType::class, $categorie);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $categorie = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();
            
            return $this->redirectToRoute('categorie');
        }
        
        return $this->render('categorie/new.html.twig', [
            'formAddCategorie' => $form->createView(),
            'editMode' => $categorie->getId() !== null

            ]);
        }








    // /**
    //  * @Route("/categorie", name="categorie")
    //  */
    // public function index(): Response
    // {
    //     return $this->render('categorie/index.html.twig', [
    //         'controller_name' => 'CategorieController',
    //     ]);
    // }

        /**
     * @Route("categorie/list", name="categorie")
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Categorie::class)
            ->findAll();

        return $this->render('categorie/index.html.twig', [
            // 'controller_name' => 'CategorieController',
            'categories' => $categories
        ]);
    }
            /**
     *  @Route("categorie/{id}", name="categorie_show")
     */
    public function show(Categorie $categorie): Response 
    {
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie
        ]);
    }

        /**
     * @Route("/categorie/delete", name="categorie_delete")
     * @Route("/categorie/{id}/delete", name="categorie_delete")
     */
    public function delete(Categorie $categorie = null, Request $request, EntityManagerInterface $manager)
    {
        $manager->remove($categorie);
        $manager->flush();
        return $this->redirectToRoute('categorie');
    }


}

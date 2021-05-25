<?php

namespace App\Controller;

use App\Entity\Module;
use App\Entity\Session;
use App\Form\ModuleType;
use App\Entity\Categorie;
use App\Entity\Programmer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/module/delete", name="module_delete")
     * @Route("/module/{id}/delete", name="module_delete")
     */
    public function delete(Module $module = null, Request $request, EntityManagerInterface $manager): Response
    {
        $manager->remove($module);
        $manager->flush();
        return $this->redirectToRoute('module');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/module/add", name="module_add")
     * @Route("/module/{id}/edit", name="module_edit")
     */
    public function add(Module $module = null, Request $request): Response
    {
        if (!$module) {
            $module = new Module();
        }

        $form = $this->createForm(ModuleType::class, $module);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $module = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($module);
            $entityManager->flush();

            return $this->redirectToRoute('module');
        }

        return $this->render('module/add_edit.html.twig', [
            'formAddModule' => $form->createView(),
            'editMode' => $module->getId() !== null
        ]);
    }
 
    /**
     * @Route("/module/list", name="module")
     */
    public function index(): Response
    {

        $modules = $this->getDoctrine()
            ->getRepository(Module::class)
            ->findAll();

        return $this->render('module/index.html.twig', [
            'modules' => $modules,
        ]);
    }

    /**
     * @Route("module/{id}", name="module_show")
     */
    public function show(Module $module)
    {
        $programmes = $this->getDoctrine()->getRepository(Programmer::class)->findBy(["module" => $module->getId()]);

        return $this->render('module/show.html.twig', [
            'module' => $module,
            'programmes' => $programmes
        ]);
    }
}

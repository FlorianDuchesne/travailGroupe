<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


class ProgrammerController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/programmer", name="programmer")
     */
    public function index(): Response
    {
        return $this->render('programmer/index.html.twig', [
            'controller_name' => 'ProgrammerController',
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** 
 * @IsGranted("ROLE_ADMIN")
 */
class StagiaireController extends AbstractController
{

    // route et nom correspondants à la fonction ci-dessous. 

    /**
     * @Route("/stagiaire/{id}/delete", name="stagiaire_delete")
     */

    // Dans cette fonction, on a besoin d'un objet stagiaire (instancié de l'entité Stagiaire), 
    //et de l'Entity Manager, objet de Doctrine (mapping objet-relationnel par défaut de Symfony), 
    //qui permet de faire des ajouts, modifications et suppressions de lignes en base de données
    public function delete(Stagiaire $stagiaire, EntityManagerInterface $manager)
    {
        // On demande au manager de supprimer le stagiaire paramétré
        $manager->remove($stagiaire);
        // flush permet de mettre à jour la base de données une fois des modifications effectuées 
        $manager->flush();
        // On se rend à la page dont la route porte le nom "stagiaire"
        return $this->redirectToRoute('stagiaire');
    }

    // Ci-dessous, deux routes différentes sont attribuées à la fonction.
    // La première permet d'ajouter un stagiaire,
    // la deuxième de modifier un stagiaire en particulier

    /**
     * @Route("/stagiaire/add", name="stagiaire_add")
     * @Route("/stagiaire/{id}/edit", name="stagiaire_edit")
     */

    // Dans les paramètres de la fonction ci-dessous, on laisse la possibilité 
    //à l'objet de stagiaire d'être nul, 
    // de manière à pouvoir soit en ajouter un, soit en modifier un existant.
    // l'objet request est instancié de la classe Request, qui permet de représenter 
    //une requête HTTP et d'accéder à ses informations.

    public function add(Stagiaire $stagiaire = null, EntityManagerInterface $manager, Request $request)
    {
        // S'il n'y a pas de stagiaire lorsque la fonction est appelée (cas de la route stagiaire_add),
        // On instancie un nouvel objet stagiaire
        if (!$stagiaire) {
            $stagiaire = new Stagiaire();
        }
        // On crée un formulaire à partir de la classe StagiaireType et de l'objet stagiaire
        // Si l'objet stagiaire vient d'être créé, le formulaire sera vide, sinon il intégrera 
        //les informations du stagiaire
        $form = $this->createForm(StagiaireType::class, $stagiaire);

        // handleRequest sert à inspecter si le formulaire est soumis, et le cas échéant à appeler la requête
        $form->handleRequest($request);
        // Si le formulaire a été soumis et est valide…
        if ($form->isSubmitted() && $form->isValid()) {
            // on assigne à l'objet stagiaire le data du formulaire
            $stagiaire = $form->getData();
            // On signale qu'on veut enregistrer l'objet stagiaire en base de données
            $manager->persist($stagiaire);
            // L'enregistrement s'effectue en base de données
            $manager->flush();
            // On se rend à la page dont le nom de route est 'stagiaire'
            return $this->redirectToRoute('stagiaire');
        }
        // La fonction renvoie la vue twig où se situe le formulaire
        // Le formulaire créé est appelé formAddStagiaire
        // 'editMode est créé si on a un id de stagiaire
        return $this->render('stagiaire/add_edit.html.twig', [
            'formAddStagiaire' => $form->createView(),
            'editMode' => $stagiaire->getId() !== null
        ]);
    }

    /**
     * @Route("stagiaire/list", name="stagiaire")
     */
    public function index()
    {
        // On appelle la méthode findAll du repository de la classe Stagiaire grâce à Doctrine, 
        // qui permet d'accéder au data de tous les objets de la classe
        $stagiaires = $this->getDoctrine()
            ->getRepository(Stagiaire::class)
            ->findAll();
        // On renvoie la vue twig de l'index stagiaire
        return $this->render('stagiaire/index.html.twig', [
            // Dans la vue twig, "stagiaires" renverra au data de l'objet $stagiaires instancié dans la fonction
            'stagiaires' => $stagiaires
        ]);
    }

    /**
     * @Route("stagiaire/{id}", name="stagiaire_show")
     */
    public function show(Stagiaire $stagiaire)
    {
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire
        ]);
    }
}

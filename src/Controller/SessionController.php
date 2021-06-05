<?php

namespace App\Controller;

use App\Entity\Salle;
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


    /**
     * @Route("/session/{id}/deleteSalle", name="delete_salle_session")
     * @IsGranted("ROLE_ADMIN")
     */
    public function deleteSalle(Session $session, Salle $salle = null, EntityManagerInterface $manager)
    {
        $salle = $session->getSalle();
        // $salle = $manager->getRepository(Salle::class)->findOneById($id);
        $salle->removeSession($session);
        $manager->flush();
        return $this->render('session/show.html.twig', [
            'session' => $session
        ]);
    }


    // Fonction d'attribution d'une salle à une session

    // /**
    //  * @Route("/session/{id}/ajoutSalle", name="ajoutSalle")
    //  * @IsGranted("ROLE_ADMIN")
    //  */
    // public function ajoutSalle(Session $session, Request $request)
    // {
    //     $form = $this->createForm(AjoutSalleToSessionType::class, $session);

    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $session = $form->getData();
    //         // Si le nombre de places de la session est supérieur au nombre de places de la salle…
    //         if ($session->getNbPlaces() > $form->get('salle')->getData()->getNbPlaces()) {
    //             // on envoie un message d'erreur
    //             $this->addFlash('warning', 'La jauge de la salle ne peut pas contenir tout l\'effectif de la session !');
    //             // Et on retourne sur la page du formulaire
    //             return $this->render('session/ajoutSalle.html.twig', [
    //                 'formAddSalleToSession' => $form->createView(),
    //             ]);
    //         }
    //         $salle = $session->getSalle();
    //         $start = $session->getDateDebut();
    //         $end = $session->getDatefin();
    //         $taken = $this->getDoctrine()->getRepository(Session::class)->findIfTaken($start, $end, $salle->getId());
    //         // dd($taken);
    //         if ($taken) {

    //             $this->addFlash('danger', 'salle déjà prise à ces dates');

    //             return $this->render('session/ajoutSalle.html.twig', [
    //                 'formAddSalleToSession' => $form->createView(),
    //             ]);
    //         }

    //         // else if{

    //         // }
    //         // Sinon, on poursuit normalement
    //         // else {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->persist($session);
    //         $entityManager->flush();

    //         return $this->render('session/show.html.twig', [
    //             'session' => $session
    //         ]);
    //     }
    //     // }
    //     // Si le formulaire n'est pas soumis, on va sur le formulaire
    //     return $this->render('session/ajoutSalle.html.twig', [
    //         'formAddSalleToSession' => $form->createView(),
    //     ]);
    // }

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
            // Si aucune session n'est paramétrée dans la fonction,
            $session = new Session();
            // On instancie une nouvelle session
        }

        $form = $this->createForm(SessionType::class, $session);
        // On crée un formulaire en paramétrant le form Builder 'SessionType' et l'instance de session

        $form->handleRequest($request);
        // On inspecte la requête http pour vérifier si le formulaire est soumis

        if ($form->isSubmitted() && $form->isValid()) {
            // s'il est soumis et qu'il est valide, on applique la condition suivante

            $session = $form->getData();
            // on attribue le data du formulaire validé à l'instance de Session

            if ($session->getNbPlaces() < count($form->get('inscrit')->getData())) {
                // Si le nombre de places de la session est inférieur au nombre de stagiaires inscrits dans le formulaire, alors…
                $this->addFlash('warningStagiaires', 'Vous ne pouvez pas inscrire autant de stagiaires à cette session');
                // on envoie un message d'erreur

                return $this->render('session/add_edit.html.twig', [
                    'formAddSession' => $form->createView(),
                    'editMode' => $session->getId() !== null
                ]);
                // Et on retourne sur la page du formulaire

            }
            // on ferme la dernière condition

            $stagiaire = $session->getInscrit();
            $start = $session->getDateDebut();
            $end = $session->getDatefin();
            $salle = $session->getSalle();

            // On définit des variables à partir des champs remplis du formulaire

            // $start = $session->getDateDebut();
            // $end = $session->getDatefin();

            if ($session->getId()) {
                // Si la session a déjà un identifiant (et donc qu'elle n'est pas une nouvelle instance)

                $salleOccupee = $this->getDoctrine()->getRepository(Session::class)->findIfTaken($start, $end, $salle->getId(), $session->getId());
                // On appelle la méthode 'findIfTaken' du Repository de la classe Session, issu de Doctrine, l'ORM de Symfony
                // Cette méthode nous renseignera à partir des paramètres fournis  pour savoir si la salle est déjà prise ou non à cette période

                foreach ($stagiaire as $stagiaire) {
                    // Pour chaque stagiaire enregistré par le formulaire,
                    $stagiaireOccupe = $this->getDoctrine()->getRepository(Session::class)->findIfStagiaireAvailable($start, $end, $stagiaire->getId(), $session->getId());
                    // On appelle une méthode qui permettra de savoir à partir des paramètres fournis si le stagiaire est déjà pris par une autre session à ces dates

                    // dd($taken);

                    if ($stagiaireOccupe) {
                        // Si le stagiaire est déjà pris,

                        $this->addFlash('danger', 'Au moins un des stagiaires est déjà pris sur une autre session à la même période !');
                        // On crée un message flash 

                        return $this->render('session/add_edit.html.twig', [
                            // Et on retourne la vue twig du formulaire, chargé du contenu du formulaire et le l'identifiant de la session s'il existe
                            'formAddSession' => $form->createView(),
                            'editMode' => $session->getId() !== null
                        ]);
                    }
                    // On sort de la condition (stagiaire occupé)
                }
                // Et on sort de la boucle 
            } else {
                // Si la session n'a PAS d'identifiant,

                $salleOccupee = $this->getDoctrine()->getRepository(Session::class)->findIfTakenNewSession($start, $end, $salle->getId());
                // On appelle la méthode 'findIfTakenNewSession' qui ne paramètre pas d'identifiant de session, et qui retourne si la salle est occupée.

                // dd($taken);

                foreach ($stagiaire as $stagiaire) {
                    // Pour chaque stagiaire enregistré par le formulaire,

                    $stagiaireOccupe = $this->getDoctrine()->getRepository(Session::class)->findIfStagiaireAvailableNewSession($start, $end, $stagiaire->getId());
                    // On appelle une méthode (qui ne paramètre pas d'identifiant de session) retournant si le stagiaire est disponible ou non 

                    // dd($taken);

                    if ($stagiaireOccupe) {
                        // Si le stagiaire est occupé, on envoie un message d'erreur et on retourne à la vue du formulaire

                        $this->addFlash('danger', 'Au moins un des stagiaires est déjà pris sur une autre session à la même période !');

                        return $this->render('session/add_edit.html.twig', [
                            'formAddSession' => $form->createView(),
                            'editMode' => $session->getId() !== null
                        ]);
                    }
                }
            }

            if ($salleOccupee) {
                // Si la salle est occupée, on envoie un message d'erreur et la vue du formulaire

                $this->addFlash('dangerSalle', 'salle déjà prise à ces dates');

                return $this->render('session/add_edit.html.twig', [
                    'formAddSession' => $form->createView(),
                    'editMode' => $session->getId() !== null
                ]);
            }

            if ($session->getNbPlaces() > $form->get('salle')->getData()->getNbPlaces()) {
                // Si le nombre de places de la session est supérieur au nombre de places de la salle,
                $this->addFlash('warning', 'La jauge de la salle ne peut pas contenir tout l\'effectif de la session !');
                // on envoie un message d'erreur
                return $this->render('session/add_edit.html.twig', [
                    // Et on retourne sur la page du formulaire
                    'formAddSession' => $form->createView(),
                    'editMode' => $session->getId() !== null
                ]);
            }

            // Sinon, on poursuit normalement : on accède au manager de Doctrine, qui nous permet d'interagir avec la base de données :
            // La méthode persiste prépare l'objet paramétré à être enregistré en base de données,
            // et la méthode flush effectue l'enregistrement ou la modification le cas échéant en base de données

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($session);
            $entityManager->flush();

            // On renvoie ensuite à la vue détaillant l'objet session instancié ou modifié

            return $this->render('session/show.html.twig', [
                'session' => $session
            ]);
        }

        // Si le formulaire n'a pas été soumis ou n'est pas valide, on retourne la vue twig du formulaire

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

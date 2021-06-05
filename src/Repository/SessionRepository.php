<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }

    // On paramètre à la fonction les dates de début et de fin de la session en cours d'enregistrement, et l'identifiant du stagiaire
    public function findIfStagiaireAvailableNewSession($debut, $fin, $id)
    {
        // On retourne la création de requête suivante, qui sélectionnera les sessions
        return $this->createQueryBuilder('s')
            // On fait un inner join sur la propriété 'inscrit' de session, qui correspond aux objets stagiaires
            ->innerJoin('s.inscrit', 'stag')
            // On cherche les sessions dont le début est avant la fin de la session en cours d'enregistrement,
            // et dont la fin est après la début de la session en cours d'enregistrement
            ->where(':debut < s.dateFin AND :fin > s.dateDebut')
            // ->where(':debut BETWEEN s.dateDebut AND s.dateFin OR :fin BETWEEN s.dateDebut AND s.dateFin')
            // Et où le stagiaire paramétré est inscrit
            ->andWhere('stag.id = :id')
            // On met en place les paramètres à la requête
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->setParameter('id', $id)
            // On construit la requête
            ->getQuery()
            // On cherche les résultats de la requête
            ->getResult();
    }

    // La méthode suivante est très proche de la précédente, mais on paramètre en plus l'id de la session, qu'on ne vient pas d'instancier.
    public function findIfStagiaireAvailable($debut, $fin, $id, $idSession)
    {

        return $this->createQueryBuilder('s')
            ->innerJoin('s.inscrit', 'stag')
            ->where(':debut < s.dateFin AND :fin > s.dateDebut')
            // ->where(':debut BETWEEN s.dateDebut AND s.dateFin OR :fin BETWEEN s.dateDebut AND s.dateFin')
            ->andWhere('stag.id = :id')
            ->andWhere('s.id != :idSession')
            // En plus de chercher que la stagiaire paramétré est inscrit à la session passée en revue,
            // On vérifie également que la session en revue n'est PAS la session paramétrée !
            // En effet, la session paramétrée est forcément concernée par les conditions de cette requête,
            // et on ne veut pas ça.
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->setParameter('id', $id)
            ->setParameter('idSession', $idSession)
            ->getQuery()
            ->getResult();
    }

    public function findIfTakenNewSession($debut, $fin, $id)
    {

        return $this->createQueryBuilder('s')
            ->innerJoin('s.salle', 'sa')
            ->where(':debut < s.dateFin AND :fin > s.dateDebut')
            // ->where(':debut BETWEEN s.dateDebut AND s.dateFin OR :fin BETWEEN s.dateDebut AND s.dateFin')
            ->andWhere('sa.id = :id')
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }


    public function findIfTaken($debut, $fin, $id, $idSession = null)
    {

        return $this->createQueryBuilder('s')
            ->innerJoin('s.salle', 'sa')
            ->where(':debut < s.dateFin AND :fin > s.dateDebut')
            // ->where(':debut BETWEEN s.dateDebut AND s.dateFin OR :fin BETWEEN s.dateDebut AND s.dateFin')
            ->andWhere('sa.id = :id')
            ->andWhere('s.id != :idSession')
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->setParameter('id', $id)
            ->setParameter('idSession', $idSession)
            ->getQuery()
            ->getResult();
    }

    public function prochainesSessions()
    {
        $currentdate = (new \DateTime('now'))->format('Y-m-d'); //Date du jour

        $qb = $this->createQueryBuilder('s')
            ->where('s.dateDebut >= :date')
            ->setParameter('date', $currentdate)
            ->orderBy('s.dateDebut', 'DESC')
            ->setMaxResults(3);
        $query = $qb->getQuery();
        return $query->execute();
    }

    // /**
    //  * @return Session[] Returns an array of Session objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Session
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

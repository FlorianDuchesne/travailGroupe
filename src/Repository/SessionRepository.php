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

    public function findIfStagiaireAvailable($debut, $fin, $id)
    {

        return $this->createQueryBuilder('s')
            ->innerJoin('s.inscrit', 'stag')
            ->where(':debut < s.dateFin AND :fin > s.dateDebut')
            // ->where(':debut BETWEEN s.dateDebut AND s.dateFin OR :fin BETWEEN s.dateDebut AND s.dateFin')
            ->andWhere('stag.id = :id')
            ->setParameter('debut', $debut)
            ->setParameter('fin', $fin)
            ->setParameter('id', $id)
            ->getQuery()
            ->getResult();
    }

    public function findIfTaken($debut, $fin, $id)
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

<?php

namespace App\Repository;

use App\Entity\Salle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Salle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Salle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Salle[]    findAll()
 * @method Salle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SalleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Salle::class);
    }

    // public function findIfTaken($debut, $fin, $id)
    // {

    //     return $this->createQueryBuilder('s')
    //         ->innerJoin('s.salle', 'sa')
    //         ->where(':debut BETWEEN s.dateDebut AND s.dateFin OR :fin BETWEEN s.dateDebut AND s.dateFin')
    //         ->andWhere('sa.id = :id')
    //         ->setParameter('debut', $debut)
    //         ->setParameter('fin', $fin)
    //         ->setParameter('id', $id)
    //         ->getQuery()
    //         ->getResult();

    //     // On a une salle désirée et une session.
    //     // Détecter si la salle est déjà prise par une autre session sur la même période.

    //     // Requête :
    //     // sélectionner la salle 
    //     // Si une session occupée par la salle a débuté avant la fin de $sessionInterrogee
    //     // et a fini après le début de $sessionInterrogee
    //     // et se déroule dans la même salle que $sessionInterrogee

    //     // SELECT sa.libelle FROM salle sa, session se 
    //     // WHERE sa.id = se.salle_id AND sa.id = 1 
    //     // AND se.date_debut < DATE('2021-06-30') 
    //     // AND se.date_fin > DATE('2021-05-03') 

    //     // $qb = $this->createQueryBuilder('s')
    //     //     ->where('s.dateDebut >= :date')
    //     //     // ->setParameter('date')
    //     //     ->orderBy('s.dateDebut', 'DESC')
    //     //     ->setMaxResults(3);
    //     // $query = $qb->getQuery();
    //     // return $query->execute();
    // }



    // /**
    //  * @return Salle[] Returns an array of Salle objects
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
    public function findOneBySomeField($value): ?Salle
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

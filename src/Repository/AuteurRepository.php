<?php

namespace App\Repository;

use App\Entity\Auteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Auteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Auteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Auteur[]    findAll()
 * @method Auteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuteurRepository extends ServiceEntityRepository
{
    private int $LIMIT_RESULT = 15;
    public function __construct(ManagerRegistry $registry = null)
    {
        parent::__construct($registry, Auteur::class);
    }

    // /**
    //  * @return Auteur[] Returns an array of Auteur objects
    //  */

    public function findByLikeField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.nom_prenom LIKE :val')
            ->setParameter('val', "%" . $value . "%")
            ->orderBy('a.id', 'ASC')
            ->setMaxResults($this->LIMIT_RESULT)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?Auteur
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

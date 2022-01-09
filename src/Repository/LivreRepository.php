<?php

namespace App\Repository;

use App\Entity\Livre;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Livre|null find($id, $lockMode = null, $lockVersion = null)
 * @method Livre|null findOneBy(array $criteria, array $orderBy = null)
 * @method Livre[]    findAll()
 * @method Livre[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LivreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Livre::class);
    }

    // /**
    //  * @return Livre[] Returns an array of Livre objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findByLikeField($q)
    {
        return $this->createQueryBuilder('l')
            //search in titre
            ->andWhere('l.titre LIKE :titre')
            ->setParameter('titre', "%" . $q . "%")
            //search in isbn
            ->orWhere('l.isbn LIKE :isbn')
            ->setParameter('isbn', "%" . $q . "%")
            //search in auteur
            ->leftJoin('l.auteurs', 'a')
            ->orWhere('a.nom_prenom LIKE :nom_prenom')
            ->setParameter('nom_prenom', "%" . $q . "%")
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
    public function findByActeur($id)
    {
        return $this->createQueryBuilder('l')
            //search in auteur
            ->leftJoin('l.auteurs', 'a')
            ->Where('a.id = :id')
            ->setParameter('id', $id)
            ->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getLivrePagineted($page = 1, $limit = null, $cat = null, $date_deb = null, $date_fin = null)
    {

        $query = $this->createQueryBuilder('l');
        if ($cat != null)
            $query->leftJoin('l.genres', 'g')
                ->andWhere('g.id = :cat')
                ->setParameter('cat', $cat);
        if ($date_deb != null)
            $query->andWhere('l.date_de_parution >= :date_deb')
                ->setParameter('date_deb', $date_deb);
        if ($date_fin != null)
            $query->andWhere('l.date_de_parution <= :date_fin')
                ->setParameter('date_fin', $date_fin);
        if ($limit != null)
            $query->setFirstResult(($limit * $page) - $limit)
                ->setMaxResults($limit);

        return $query->orderBy('l.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function getLivrePaginetedCount($cat = null, $date_deb = null, $date_fin = null)
    {

        $query = $this->createQueryBuilder('l');
        $query->select('COUNT(l)');
        if ($cat != null)
            $query->leftJoin('l.genres', 'g')
                ->andWhere('g.id = :cat')
                ->setParameter('cat', $cat);
        if ($date_deb != null)
            $query->andWhere('l.date_de_parution >= :date_deb')
                ->setParameter('date_deb', $date_deb);
        if ($date_fin != null)
            $query->andWhere('l.date_de_parution <= :date_fin')
                ->setParameter('date_fin', $date_fin);

        return $query->getQuery()
            ->getSingleScalarResult();
    }

    /*
    public function findOneBySomeField($value): ?Livre
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

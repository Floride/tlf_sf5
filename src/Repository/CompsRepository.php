<?php

namespace App\Repository;

use App\Entity\Comps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comps|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comps|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comps[]    findAll()
 * @method Comps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comps::class);
    }

    // /**
    //  * @return Comps[] Returns an array of Comps objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Comps
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

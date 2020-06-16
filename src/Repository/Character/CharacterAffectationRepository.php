<?php

namespace App\Repository\Character;

use App\Entity\Character\CharacterAffectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CharacterAffectation|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterAffectation|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterAffectation[]    findAll()
 * @method CharacterAffectation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterAffectationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterAffectation::class);
    }

    // /**
    //  * @return CharacterAffectation[] Returns an array of CharacterAffectation objects
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
    public function findOneBySomeField($value): ?CharacterAffectation
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

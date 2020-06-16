<?php

namespace App\Repository\Character;

use App\Entity\Character\CharacterMedal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CharacterMedal|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterMedal|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterMedal[]    findAll()
 * @method CharacterMedal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterMedalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterMedal::class);
    }

    // /**
    //  * @return CharacterMedal[] Returns an array of CharacterMedal objects
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
    public function findOneBySomeField($value): ?CharacterMedal
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

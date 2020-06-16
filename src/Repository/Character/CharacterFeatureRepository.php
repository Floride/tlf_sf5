<?php

namespace App\Repository\Character;

use App\Entity\Character\CharacterFeature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CharacterFeature|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterFeature|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterFeature[]    findAll()
 * @method CharacterFeature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterFeatureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterFeature::class);
    }

    // /**
    //  * @return CharacterFeature[] Returns an array of CharacterFeature objects
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
    public function findOneBySomeField($value): ?CharacterFeature
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

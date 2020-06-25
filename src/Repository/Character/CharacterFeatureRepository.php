<?php

namespace App\Repository\Character;

use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Character\CharacterFeature;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    /**
     * findByNameQuery
     *
     * @param string|null $order
     * @return Query
     */
    public function findByNameQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('cf')
            ->orderBy('cf.name', $order)
            ->getQuery()
        ;
    }
}

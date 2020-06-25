<?php

namespace App\Repository\Character;

use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Character\CharacterAffectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    /**
     * findByNameQuery
     *
     * @param string|null $order
     * @return Query
     */
    public function findByNameQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('ca')
            ->orderBy('ca.name', $order)
            ->getQuery()
        ;
    }
}

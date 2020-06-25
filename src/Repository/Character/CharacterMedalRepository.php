<?php

namespace App\Repository\Character;

use Doctrine\ORM\Query;
use App\Entity\Character\CharacterMedal;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

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

    /**
     * findByNameQuery
     *
     * @param string|null $order
     * @return Query
     */
    public function findByNameQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('cm')
            ->orderBy('cm.name', $order)
            ->getQuery()
        ;
    }
}

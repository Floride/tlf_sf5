<?php

namespace App\Repository\Character;

use App\Entity\Character\Medal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Medal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Medal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Medal[]    findAll()
 * @method Medal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MedalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Medal::class);
    }

    /**
     * findByNameQuery
     *
     * @param string|null $order
     * @return Query
     */
    public function findByNameQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('c')
            ->OrderBy('c.value', 'ASC')
            ->addOrderBy('c.type', 'ASC')
            ->addOrderBy('c.category', 'ASC')
            ->addOrderBy('c.name', $order)
            ->getQuery()
        ;
    }
}

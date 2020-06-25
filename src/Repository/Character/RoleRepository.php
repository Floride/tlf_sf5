<?php

namespace App\Repository\Character;

use Doctrine\ORM\Query;
use App\Entity\Character\Role;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Role|null find($id, $lockMode = null, $lockVersion = null)
 * @method Role|null findOneBy(array $criteria, array $orderBy = null)
 * @method Role[]    findAll()
 * @method Role[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Role::class);
    }

    /**
     * findByNameQuery
     *
     * @param string|null $order
     * @return Query
     */
    public function findByNameQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('r')
            ->OrderBy('r.type', 'ASC')
            ->addOrderBy('r.name', $order)
            ->getQuery()
        ;
    }
    
    /**
     * getObsolete
     *
     * @param bool $bool
     * 
     * @return QueryBuilder
     */
    public function getObsolete(bool $bool = false): QueryBuilder
    {
        return $this->createQueryBuilder('r')
            ->where('r.obsolete = :obsolete')
            ->setParameter('obsolete', $bool)
        ;
    }
}

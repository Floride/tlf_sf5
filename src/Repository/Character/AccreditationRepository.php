<?php

namespace App\Repository\Character;

use Doctrine\ORM\Query;
use App\Entity\Character\Accreditation;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Accreditation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Accreditation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Accreditation[]    findAll()
 * @method Accreditation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccreditationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Accreditation::class);
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
            ->addOrderBy('c.level', 'ASC')
            ->addOrderBy('c.type', 'ASC')
            ->addOrderBy('c.category', 'ASC')
            ->addOrderBy('c.name', $order)
            ->getQuery()
        ;
    }
}

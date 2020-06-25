<?php

namespace App\Repository\Character;

use Doctrine\ORM\Query;
use App\Entity\Character\Character;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * @method Character|null find($id, $lockMode = null, $lockVersion = null)
 * @method Character|null findOneBy(array $criteria, array $orderBy = null)
 * @method Character[]    findAll()
 * @method Character[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Character::class);
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
            ->orderBy('c.lastname', $order)
            ->addOrderBy('c.firstname', $order)
            ->getQuery()
        ;
    }
}

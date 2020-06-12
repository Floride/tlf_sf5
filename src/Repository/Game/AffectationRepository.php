<?php

namespace App\Repository\Game;
// src\Repository\Game\AffectationRepository.php
use App\Entity\Game\Affectation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class SpecialityRepository
 *
 * PHP version 7.2.5
 *
 * @package    App\Repository
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @method Affectation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Affectation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Affectation[]    findAll()
 * @method Affectation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationRepository extends ServiceEntityRepository
{
    /**
     * AffectationRepository Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Affectation::class);
    }

    /**
     * findByNameQuery
     *
     * @param string|null $order
     * @return Query
     */
    public function findByNameQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.name', $order)
            ->getQuery()
        ;
    }
}

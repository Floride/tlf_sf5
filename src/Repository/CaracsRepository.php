<?php

namespace App\Repository;

use App\Entity\Caracs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Caracs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caracs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caracs[]    findAll()
 * @method Caracs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caracs::class);
    }
}

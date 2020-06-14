<?php
// src\Repository\Game\Geo\LuminaryRepository.php
namespace App\Repository\Game\Geo;

use Doctrine\ORM\Query;
use App\Entity\Game\Geo\Luminary;
use App\Entity\Game\Geo\LuminaryType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class LuminaryRepository
 *
 * PHP version 7.2.5
 *
 * @method Luminary|null find($id, $lockMode = null, $lockVersion = null)
 * @method Luminary|null findOneBy(array $criteria, array $orderBy = null)
 * @method Luminary[]    findAll()
 * @method Luminary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LuminaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Luminary::class);
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
            ->leftJoin('a.type', 't')
            ->orderBy('t.name', $order)
            ->addOrderBy('a.name', $order)
            ->getQuery()
        ;
    }
}

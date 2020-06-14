<?php
// src\Repository\Game\Geo\PlaceRepository.php
namespace App\Repository\Game\Geo;

use Doctrine\ORM\Query;
use App\Entity\Game\Geo\Place;
use App\Entity\Game\Geo\LuminaryType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class PlaceRepository
 *
 * PHP version 7.2.5
 *
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Place::class);
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
            //->leftJoin(LuminaryType::class, 't')
            //->orderBy('t.name', $order)
            ->addOrderBy('a.name', $order)
            ->getQuery()
        ;
    }
}

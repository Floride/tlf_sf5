<?php
// src\Repository\Game\Geo\PlaceRepository.php
namespace App\Repository\Game\Geo;

use Doctrine\ORM\Query;
use App\Entity\Game\Geo\Place;
use Doctrine\ORM\QueryBuilder;
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
            ->leftJoin('a.type', 't')
            ->orderBy('t.name', $order)
            ->addOrderBy('a.name', $order)
            ->getQuery()
        ;
    }
    
    /**
     * getBirthPlace
     *
     * @param bool $bool
     * 
     * @return QueryBuilder
     */
    public function getBirthPlace(bool $bool = false): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.type', 't')
            ->leftJoin('p.luminary', 'l')
            ->leftJoin('p.parent', 'd')
            ->where('p.obsolete = :obsolete')
            ->andWhere('p.birthPlace = true')
            ->orderBy('l.name')
            ->addOrderBy('d.name')
            ->addOrderBy('t.name')
            ->addOrderBy('p.name')
            ->setParameter('obsolete', $bool)
        ;
    }

    /**
     * getBirthPlace
     *
     * @param bool $bool
     * 
     * @return QueryBuilder
     */
    public function getRecruitmentPlace(bool $bool = false): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('p.type', 't')
            ->leftJoin('p.luminary', 'l')
            ->leftJoin('p.parent', 'd')
            ->where('p.obsolete = :obsolete')
            ->andWhere('p.recruitmentPlace = true')
            ->orderBy('l.name')
            ->addOrderBy('d.name')
            ->addOrderBy('t.name')
            ->addOrderBy('p.name')
            ->setParameter('obsolete', $bool)
        ;
    }
}

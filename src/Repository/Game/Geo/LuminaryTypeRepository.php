<?php
// src\Repository\Game\Geo\LuminaryTypeRepository.php
namespace App\Repository\Game\Geo;

use Doctrine\ORM\Query;
use App\Entity\Game\Geo\LuminaryType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class LuminaryTypeRepository
 *
 * PHP version 7.2.5
 *
 * @method LuminaryType|null find($id, $lockMode = null, $lockVersion = null)
 * @method LuminaryType|null findOneBy(array $criteria, array $orderBy = null)
 * @method LuminaryType[]    findAll()
 * @method LuminaryType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LuminaryTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LuminaryType::class);
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

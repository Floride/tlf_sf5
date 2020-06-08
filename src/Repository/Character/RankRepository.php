<?php
// src\Repository\Character\RankRepository.php
namespace App\Repository\Character;

use Doctrine\ORM\Query;
use App\Entity\Character\Rank;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class ProfessionRepository
 *
 * PHP version 7.2.5
 *
 * @package    App\Repository
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 * 
 * @method Rank|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rank|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rank[]    findAll()
 * @method Rank[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RankRepository extends ServiceEntityRepository
{
    /**
     * RankRepository Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rank::class);
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
            ->OrderBy('c.type', 'ASC')
            ->addOrderBy('c.category', 'ASC')
            ->addOrderBy('c.score', 'ASC')
            ->addOrderBy('c.name', $order)
            ->getQuery()
        ;
    }
}

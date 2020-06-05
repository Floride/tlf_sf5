<?php
// src\Repository\CompsRepository.php
namespace App\Repository;

use App\Entity\Comps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * Class CompsRepository
 *
 * PHP version 7.2
 *
 * @package    App\Repository
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @method Comps|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comps|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comps[]    findAll()
 * @method Comps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompsRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comps::class);
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
            ->orderBy('c.nom', $order)
            ->getQuery()
        ;
    }
}

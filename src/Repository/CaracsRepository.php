<?php
// src\Repository\CaracsRepository.php
namespace App\Repository;

use App\Entity\Caracs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * Class CaracsRepository
 *
 * PHP version 7.2
 *
 * @package    App\Repository
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @method Caracs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Caracs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Caracs[]    findAll()
 * @method Caracs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaracsRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Caracs::class);
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

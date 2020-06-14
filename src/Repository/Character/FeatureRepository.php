<?php
// src\Repository\Character\FeatureRepository.php
namespace App\Repository\Character;

use App\Entity\Character\Feature;
use App\Entity\Character\Skill;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * Class FeatureRepository
 *
 * PHP version 7.2.5
 *
 * @package    App\Repository
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.1.0
 *
 * @method Feature|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feature|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feature[]    findAll()
 * @method Feature[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeatureRepository extends ServiceEntityRepository
{
    /**
     * FeatureRepository Constructor
     *
     * @param ManagerRegistry $registry
     * 
     * @return void
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feature::class);
    }

    /**
     * findByNameQuery
     *
     * @param string|null $order
     * 
     * @return Query
     */
    public function findByNameQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.name', $order)
            ->getQuery()
        ;
    }
}

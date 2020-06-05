<?php
// src\Repository\SiteFaqsRepository.php
namespace App\Repository;

use App\Entity\SiteFaqs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Query;

/**
 * Class SiteFaqsRepository
 *
 * PHP version 7.2
 *
 * @package    App\Repository
 * @author     Sylvain FLORIDE <sfloride@gmail.com>
 * @version    1.0.0
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SiteFaqsRepository extends ServiceEntityRepository
{
    /**
     * Constructor
     *
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SiteFaqs::class);
    }

    /**
     * findByQuestionQuery
     *
     * @param string|null $order
     * @return Query
     */
    public function findByQuestionQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.question', $order)
            ->getQuery()
        ;
    }
}

<?php

namespace App\Repository\Character;

use Doctrine\ORM\Query;
use App\Entity\Character\CharacterSkill;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method CharacterSkill|null find($id, $lockMode = null, $lockVersion = null)
 * @method CharacterSkill|null findOneBy(array $criteria, array $orderBy = null)
 * @method CharacterSkill[]    findAll()
 * @method CharacterSkill[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CharacterSkillRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CharacterSkill::class);
    }

    /**
     * findByNameQuery
     *
     * @param string|null $order
     * @return Query
     */
    public function findByNameQuery(?string $order = 'ASC'): Query 
    {
        return $this->createQueryBuilder('cs')
            ->orderBy('cs.name', $order)
            ->getQuery()
        ;
    }
}

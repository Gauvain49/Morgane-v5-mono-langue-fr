<?php

namespace App\Repository;

use App\Entity\MgPosts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MgPosts|null find($id, $lockMode = null, $lockVersion = null)
 * @method MgPosts|null findOneBy(array $criteria, array $orderBy = null)
 * @method MgPosts[]    findAll()
 * @method MgPosts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MgPostsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MgPosts::class);
    }

    // /**
    //  * @return MgPosts[] Returns an array of MgPosts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MgPosts
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

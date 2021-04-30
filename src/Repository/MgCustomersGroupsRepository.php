<?php

namespace App\Repository;

use App\Entity\MgCustomersGroups;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MgCustomersGroups|null find($id, $lockMode = null, $lockVersion = null)
 * @method MgCustomersGroups|null findOneBy(array $criteria, array $orderBy = null)
 * @method MgCustomersGroups[]    findAll()
 * @method MgCustomersGroups[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MgCustomersGroupsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MgCustomersGroups::class);
    }

    // /**
    //  * @return MgCustomersGroups[] Returns an array of MgCustomersGroups objects
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
    public function findOneBySomeField($value): ?MgCustomersGroups
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

<?php

namespace App\Repository;

use App\Entity\MgDepartmentsFrench;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MgDepartementsFrench|null find($id, $lockMode = null, $lockVersion = null)
 * @method MgDepartementsFrench|null findOneBy(array $criteria, array $orderBy = null)
 * @method MgDepartementsFrench[]    findAll()
 * @method MgDepartementsFrench[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MgDepartmentsFrenchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MgDepartmentsFrench::class);
    }

    // /**
    //  * @return MgDepartementsFrench[] Returns an array of MgDepartementsFrench objects
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
    public function findOneBySomeField($value): ?MgDepartementsFrench
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

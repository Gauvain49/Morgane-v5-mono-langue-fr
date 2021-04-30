<?php

namespace App\Repository;

use App\Entity\MgPropertiesValues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MgPropertiesValues|null find($id, $lockMode = null, $lockVersion = null)
 * @method MgPropertiesValues|null findOneBy(array $criteria, array $orderBy = null)
 * @method MgPropertiesValues[]    findAll()
 * @method MgPropertiesValues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MgPropertiesValuesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MgPropertiesValues::class);
    }

    // /**
    //  * @return MgPropertiesValues[] Returns an array of MgPropertiesValues objects
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
    public function findOneBySomeField($value): ?MgPropertiesValues
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

<?php

namespace App\Repository;

use App\Entity\MgProductsProperties;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MgProductsProperties|null find($id, $lockMode = null, $lockVersion = null)
 * @method MgProductsProperties|null findOneBy(array $criteria, array $orderBy = null)
 * @method MgProductsProperties[]    findAll()
 * @method MgProductsProperties[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MgProductsPropertiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MgProductsProperties::class);
    }

    // /**
    //  * @return MgProductsProperties[] Returns an array of MgProductsProperties objects
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
    public function findOneBySomeField($value): ?MgProductsProperties
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

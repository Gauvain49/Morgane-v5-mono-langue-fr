<?php

namespace App\Repository;

use App\Entity\MgProductsNumericals;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MgProductsNumericals|null find($id, $lockMode = null, $lockVersion = null)
 * @method MgProductsNumericals|null findOneBy(array $criteria, array $orderBy = null)
 * @method MgProductsNumericals[]    findAll()
 * @method MgProductsNumericals[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MgProductsNumericalsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MgProductsNumericals::class);
    }

    // /**
    //  * @return MgProductsNumericals[] Returns an array of MgProductsNumericals objects
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
    public function findOneBySomeField($value): ?MgProductsNumericals
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

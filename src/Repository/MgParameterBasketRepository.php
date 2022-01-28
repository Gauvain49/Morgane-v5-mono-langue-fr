<?php

namespace App\Repository;

use App\Entity\MgParameterBasket;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MgParameterBasket|null find($id, $lockMode = null, $lockVersion = null)
 * @method MgParameterBasket|null findOneBy(array $criteria, array $orderBy = null)
 * @method MgParameterBasket[]    findAll()
 * @method MgParameterBasket[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MgParameterBasketRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MgParameterBasket::class);
    }

    // /**
    //  * @return MgParameterBasket[] Returns an array of MgParameterBasket objects
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
    public function findOneBySomeField($value): ?MgParameterBasket
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

<?php

namespace App\Repository;

use App\Entity\MgUsers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method MgUsers|null find($id, $lockMode = null, $lockVersion = null)
 * @method MgUsers|null findOneBy(array $criteria, array $orderBy = null)
 * @method MgUsers[]    findAll()
 * @method MgUsers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MgUsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MgUsers::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof MgUsers) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findByRole($role)//par exemple $role ="ROLE_GESTIONNAIRE"
    {
        $qb = $this->createQueryBuilder('u');
        //$qb->select('u')
        //->from($this->_entityName, 'u')
        $qb->where('u.roles LIKE :roles')
        //->andwhere('u.enabled = :enabled')
        ->setParameter('roles', '%"'.$role.'"%')
        //->setParameter('enabled', true)
        ;
        return $qb->getQuery()->getResult();
    }

    // /**
    //  * @return MgUsers[] Returns an array of MgUsers objects
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
    public function findOneBySomeField($value): ?MgUsers
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

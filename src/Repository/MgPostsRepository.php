<?php

namespace App\Repository;

use App\Entity\MgPosts;
use App\Services\TreeStructure;
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
    public function __construct(ManagerRegistry $registry, TreeStructure $tree)
    {
        parent::__construct($registry, MgPosts::class);
        $this->tree = $tree;
    }

    /**
     * Affichage des pages par arborescence
     */
    public function findAllByArborescence()
    {
        $array = [];
        $pages = $this->findBy(['type' => 'page', 'status' => 'publish'], ['sort' => 'ASC']);
        foreach ($pages as $page) {
            $parent = !is_null($page->getParent()) ? $this->find($page->getParent())->getId() : 0;
            $array[] = [
                'parent' => $parent,
                'id' => $page->getId(),
                'nom' => $page->getTitle()
            ];
        }
        $result = $this->tree->treeStructure(0, 0, $array, '—');
        $arborescence = [];
        foreach ($result as $key => $value) {
            $arborescence[$key] = $this->find($value);
        }
        return $arborescence;
    }

    /**
     * Attribution automatique d'une position
     */
    public function setPosition($parent)
    {
        //On récupère la dernière position en appelant les pages du même parent
        $lastPosition = $this->findOneBy(['type' => 'page', 'parent' => $parent], ['sort' => 'DESC']);
        $position = !empty($lastPosition) ? $lastPosition->getsort() + 1 : 1;
        return $position;
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

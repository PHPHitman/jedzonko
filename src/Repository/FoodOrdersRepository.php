<?php

namespace App\Repository;

use App\Entity\FoodOrders;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FoodOrders|null find($id, $lockMode = null, $lockVersion = null)
 * @method FoodOrders|null findOneBy(array $criteria, array $orderBy = null)
 * @method FoodOrders[]    findAll()
 * @method FoodOrders[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodOrdersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FoodOrders::class);
    }

    // /**
    //  * @return FoodOrders[] Returns an array of FoodOrders objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FoodOrders
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

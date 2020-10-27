<?php

namespace App\Repository;

use App\Entity\Food;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use http\Env\Request;
use PhpParser\Node\Stmt\Return_;

/**
 * @method Food|null find($id, $lockMode = null, $lockVersion = null)
 * @method Food|null findOneBy(array $criteria, array $orderBy = null)
 * @method Food[]    findAll()
 * @method Food[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Food::class);


    }
    public function search($search){

    $queryBuilder = $this->createQueryBuilder('c')
        ->where('c.name LIKE :name')
        ->setParameter('name',$search.'%')
    ->getQuery()
        ->getResult();


        foreach($queryBuilder as $query) {

            $array = array(
                'id' => $query
            );

        }
                Return $array;
        }



public function findProducts(Request $request){


}
}


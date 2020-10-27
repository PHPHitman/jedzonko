<?php


namespace App\Service;


use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DisplayFoodMenu extends AbstractController
{
public function find(FoodRepository $foodRepository){
    $conn = $this->getEntityManager()->getConnection();

    $sql = '
        SELECT * FROM product p
        WHERE p.price > :price
        ORDER BY p.price ASC
        ';
}
}
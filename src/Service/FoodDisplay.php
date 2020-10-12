<?php


namespace App\Service;


use App\Entity\Food;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FoodDisplay extends AbstractController
{

    public function select($category){
        $em = $this->getDoctrine()->getRepository(Food::class)
            ->findBy([
                'category' => 3
            ]);
        return $em;


    }
}
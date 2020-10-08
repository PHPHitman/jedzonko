<?php


namespace App\Service;


use App\Entity\Food;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FoodDisplay extends AbstractController
{

    public function select(Food $food){
        $em = $this->getDoctrine()->getRepository(Food::class)->findAll();
        return $em;
    }
}
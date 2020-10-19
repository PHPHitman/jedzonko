<?php


namespace App\Service;


use App\Entity\Food;
use App\Entity\FoodOrders;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderDisplay extends AbstractController
{

    public function display(){

        $date=new \DateTime();
        $orders=$this->getDoctrine()->getRepository(FoodOrders::class)->findBy([
            'date'=>$date
        ]);
        $foods=$this->getDoctrine()->getRepository(Food::class);

        //find id from orders
        foreach ($orders as $order) {
            $id = $order->getProducts();
            $food= $foods->find($id);

        }


    }
}
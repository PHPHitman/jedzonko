<?php


namespace App\Service;

use App\Entity\Food;
use App\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class OrderPicker extends AbstractController
{

    public function checkIfOrderExist(){

    }
    public function insert($array)
    {

        $user=$this->getUser()->getUsername();
        $food=$this->getDoctrine()->getRepository(Food::class);

        foreach($array as $arr){
            $id=$arr->id;
            $product=$food->find($id);

            $Order = new Orders();
            $Order->setName($user);
            $Order->setProducts($product);

            $em=$this->getDoctrine()->getManager();
            $em->persist($Order);
            $em->flush();
        }
    }
}
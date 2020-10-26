<?php


namespace App\Service;


use App\Entity\Food;
use App\Entity\Orders;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DeleteSingleProduct extends AbstractController
{
    public function deleteSingle($id)
    {
        $date = new \DateTime();
        $user = $this->getUser()->getUsername();
        $food=$this->getDoctrine()->getRepository(Food::class);

        foreach ($id as $product) {

            $orders = $this->getDoctrine()
                ->getRepository(Orders::class)
                ->findBy([
                    'Date' => $date,
                    'Name' => $user,
                    'Products'=>$product->id
                ]);


            $em= $this->getDoctrine()->getManager();
            foreach($orders as $order){
                $em->remove($order);
                $em->flush();
            }
        }
    }

}
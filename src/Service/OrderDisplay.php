<?php


namespace App\Service;


use App\Entity\Food;
use App\Entity\FoodOrders;
use App\Entity\Orders;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class OrderDisplay extends AbstractController
{

    private $orderExist=0;

    /**
     * @return int
     */
    public function getOrderExist(): int
    {
        return $this->orderExist;
    }

    /**
     * @param int $orderExist
     */
    public function setOrderExist(int $orderExist): void
    {
        $this->orderExist = $orderExist;
    }




    public function display()
    {

        $orders=$this->checkIfOrderExist();


        //find id from orders

        $productDetails = array();
        $counter = 0;
        $totalPrice=0;

        if($orders) {
            foreach ($orders as $order) {

                $food = $order->getProducts();



                $temp = array(
                    'id'=>$food->getId(),
                    'product' => $food->getName(),
                    'price' => $food->getPrice(),
                    'category' => $food->getCategory(),
                );


                $productDetails[$counter] = $temp;
                $counter++;
                $totalPrice+=$food->getPrice();


            }

            $productDetails[$counter]=array(
                'total_price'=>$totalPrice
            );

            return $productDetails;
        }

    }
    public function checkIfOrderExist()
    {
        $user = $this->getUser()->getUsername();
        $date = new DateTime;
//

        $orders = $this->getDoctrine()->getRepository(Orders::class)->findBy([
            'Date' => $date,
            'Name' => $user
        ]);

        if ($orders) {

            $this->setOrderExist(1);

            return $orders;

        }


    }

}
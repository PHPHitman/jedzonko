<?php


namespace App\Service;


use App\Entity\Company;
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
        $id='';

        if($orders) {

            $company='';
            foreach ($orders as $order) {

                $food = $order->getProducts();
                $company=$food->getCompany();

                $temp = array(
                    'id'=>$food->getId(),
                    'product' => $food->getName(),
                    'price' => $food->getPrice(),
                    'category' => $food->getCategory(),
                    'orderId'=>$order->getId()
                );


                $productDetails[$counter] = $temp;
                $counter++;
                $totalPrice+=$food->getPrice();
                $id=$order->getId();
                $company=$food->getCompany()->getName();



            }


            $status= $this->getDoctrine()->getRepository(Orders::class)
                ->find($id)->getStatus();




            $productDetails[$counter]=array(
                'total_price'=>$totalPrice,
                'status'=>$status,
                'company'=>$company,

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
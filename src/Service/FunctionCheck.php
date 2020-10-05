<?php


namespace App\Service;


use App\Entity\Orders;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class FunctionCheck extends AbstractController
{
    public function check()
    {
        $user = $this->getUser()->getUsername();
        $array = explode(' ', $user);
        $date = new \DateTime();
        $result = $date->format('Y-m-d');
        $array2 = explode(' ', $result);


        $repository = $this->getDoctrine()->getRepository(Orders::class);
        $orders = $repository->findBy(
            ['Name' => $array, 'Date' => $array2]
        );
        return $orders;

    }
}
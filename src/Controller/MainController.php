<?php

namespace App\Controller;

use App\Service\FoodDisplay;
use App\Service\FunctionCheck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/profile", name="index")
     * @param FunctionCheck $functionCheck
     * @param FoodDisplay $foodDisplay
     * @return Response
     */
    public function index(FunctionCheck $functionCheck, FoodDisplay $foodDisplay)
    {


        $food= $foodDisplay->select(1);
        $drinks= $foodDisplay->select(2);
        $desserts= $foodDisplay->select(3);
        $orders = $functionCheck->check();


        return $this->render('main/index.html.twig',[
            'orders' => $orders,
            'foods' => $food,
            'drinks' => $drinks,
            'desserts' => $desserts
        ]);


    }


}

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
     * @return Response
     */
    public function index(FunctionCheck $functionCheck)
    {
//        $food= $foodDisplay->select();
        $orders = $functionCheck->check();

        return $this->render('main/index.html.twig',[
            'orders' => $orders,
//            'foods' => $food
        ]);


    }
    /**
     * @Route("/u", name="u")
     * @param FunctionCheck $functionCheck
     * @return Response
     */
    public function index2()
    {

        return $this->render('main/index2.html.twig',[

        ]);
    }

}

<?php

namespace App\Controller;

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
        $orders = $functionCheck->check();
        return $this->render('main/index.html.twig',[
            'orders' => $orders
        ]);
    }


}

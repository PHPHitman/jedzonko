<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/profile", name="index")
     */
    public function index()
    {
        return $this->render('main/index.html.twig');
    }


}

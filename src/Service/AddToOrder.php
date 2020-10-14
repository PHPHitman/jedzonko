<?php


namespace App\Service;


use App\Entity\Orders;

class AddToOrder
{
public function Add(){
    $text1 = $_POST['text1'];
    $text2 = $_POST['text2'];
    echo $text1 + $text2;
}
}
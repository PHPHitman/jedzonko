<?php


namespace App\Service;

use App\Entity\Category;
use App\Entity\Food;
use JsonSerializable;
use PhpParser\JsonDecoder;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Maker\MakeSerializerEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class OrderPicker extends AbstractController
{

    private $idArray=array();

    /**
     * @return array
     */
    public function getIdArray()
    {
        return $this->idArray;
    }

    /**
     * @param array $idArray
     * @param int $counter
     */
    public function setIdArray(array $idArray,int $counter): void
    {
        $this->idArray[$counter] = $idArray;
    }



    public function insert($array)
    {

        $user=$this->getUser()->getUsername();
        $index=0;

        $food=$this->getDoctrine()->getRepository(Food::class);
        $category = $this->getDoctrine()->getRepository(Category::class);

        foreach($array as $arr){
            $id=$arr->id;

            $product= $food->find($id);

            $categoryId=$product->getCategory();
            $categoryName= $category->find($categoryId)->getName();

            $price=$product->getPrice();
            $name=$product->getName();

            $orders = array("name"=>$name, "price"=>$price, 'category'=>$categoryName);

            $this->setIdArray($orders,$index);
            $index++;
        }


        print_r($this->getIdArray());
        return $this->getIdArray();



    }

    public function select(){

        return $this->getIdArray();

    }



}
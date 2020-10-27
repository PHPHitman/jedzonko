<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\FoodOrders;
use App\Form\FoodAddType;
use App\Repository\FoodRepository;
use App\Service\AddToOrder;
use App\Service\DeleteSingleProduct;
use App\Service\FoodDisplay;
use App\Service\OrderDisplay;
use App\Service\OrderPicker;
use PhpParser\Node\Stmt\Return_;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
    /**
     * @Route("/food", name="food.")
     */
{
    /**
     * @Route("/check", name="check")
     * @param Request $request
     * @param OrderDisplay $orderDisplay
     * @return Response
     */
    public function checkIfOrderExist(Request $request, OrderDisplay $orderDisplay)
    {
        if ($request->isXmlHttpRequest()) {
            $status = $orderDisplay->checkIfOrderExist();
            if ($status) {
                $status = 1;
            } else {
                $status = 0;
            }
            return new Response($status);
        } else {
            return $this->render('main/index.html.twig');
        }

    }

    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $food = new Food();
        $form = $this->createForm(FoodAddType::class, $food);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            //Add this field to get guessClientsExtension
            /** @var UploadedFile $file */

            //to get key name have to dump $request
            $file = $request->files->get('food_add')['picture'];

            //Save file if properly added
            if ($file) {
                $filename = md5(uniqid()) . '.' . $file->guessClientExtension();

                //Move file to public folder
                $file->move(
                // TODO: get target directory ,
                    $this->getParameter('uploads_dir'),
                    $filename
                );

                $food->setImage($filename);
                $em->persist($food);
                $em->flush();

                $this->addFlash('success', 'Produkt został dodany!');
                return $this->redirect($this->generateUrl('index'));
            }
        }

        return $this->render('food/index.html.twig', [
            'form' => $form->createView()
        ]);


    }

    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @param OrderPicker $orderPicker
     * @return JsonResponse|Response
     */

    public function ajaxAction(Request $request, OrderPicker $orderPicker)
    {
        $data = $_POST['id'];
//        $array=$_POST['array'];

        if ($request->isXmlHttpRequest()) {


            $foods = $this->getDoctrine()
                ->getRepository(Food::class)
                ->findBy([
                    'id' => $data
                ]);

            //Add id to array

            $jsonData = array();
            $idx = 0;

            foreach ($foods as $food) {

                $temp = array(
                    'name' => $food->getName(),
                    'price' => $food->getPrice(),
                'id'=>$food->getId());

                $jsonData[$idx++] = $temp;
            }


            return new JsonResponse($jsonData);
        } else {
            return $this->render('main/index.html.twig');
        }

    }

    /**
     * @Route("/save", name="save")
     * @param Request $request
     * @param OrderPicker $orderPicker
     * @param DeleteSingleProduct $deleteSingleProduct
     * @return JsonResponse|Response
     */

    public function saveOrder(Request $request, OrderPicker $orderPicker, DeleteSingleProduct $deleteSingleProduct)
    {

        $array = json_decode($_POST['array']);
        $delete = json_decode($_POST['deleteArray']);

        if ($request->isXmlHttpRequest()) {

            $deleteSingleProduct->deleteSingle($delete);
            $orderPicker->insert($array);

            return new Response('Zamowienie złożone');

        } else {
            return new Response('This is not ajax!', 400);

        }

    }

    /**
     * @Route("/show", name="show")
     * @param Request $request
     * @param OrderDisplay $orderDisplay
     * @return JsonResponse|Response
     */

    public function show(Request $request, OrderDisplay $orderDisplay)
    {

        if ($request->isXmlHttpRequest()) {

            $foodDetails = $orderDisplay->display();
            return new JsonResponse($foodDetails);

        } else {
            return $this->render('main/index.html.twig');
        }
    }

    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @param FoodRepository $foodRepository
     * @return JsonResponse|Response
     */

    public function search(Request $request, FoodRepository $foodRepository)
    {

        if ($request->isXmlHttpRequest()) {

            $search = $_POST['search'];

            $foods = $foodRepository->search($search);

            $foodArray=array();
                $counter=0;
            $index=0;
            foreach ($foods as $food){
                $temp=array(
                    'id'=>$food->getId(),
                    'image'=>$food->getImage(),
                    'name'=>$food->getName(),
                    'price'=>$food->getPrice()
                );


                $foodArray[$counter]=$temp;
                $index++;
            }

            return new JsonResponse($foodArray);


        } else {
            return new Response('błąd');
        }

    }

    /**
     * @Route("/category", name="category")
     * @param Request $request
     * @param FoodRepository $foodRepository
     * @return JsonResponse|Response
     */
    public function select(Request $request, FoodRepository $foodRepository){
        if($request->isXmlHttpRequest()){


            $company=$_POST['company'];
            $em = $this->getDoctrine()->getManager();

            $RAW_QUERY = 'SELECT f.* ,ct.name AS catName  FROM Food AS f LEFT JOIN Company c ON f.company_id=c.id LEFT JOIN category ct ON f.category_id=ct.id WHERE c.name=:company ';

            $statement = $em->getConnection()->prepare($RAW_QUERY);
            $statement->bindParam(':company',$company);
            $statement->execute();
            $result = $statement->fetchAll();
            if($result) {
                return new JsonResponse($result);
            }
            return new JsonResponse('Nie znaleziono produktów');

        }else{

            Return new JsonResponse('Wystąpił błąd');

        }
    }
}

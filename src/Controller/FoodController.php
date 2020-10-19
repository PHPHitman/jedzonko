<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\FoodOrders;
use App\Form\FoodAddType;
use App\Service\AddToOrder;
use App\Service\FoodDisplay;
use App\Service\OrderDisplay;
use App\Service\OrderPicker;
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
     * @Route("/test", name="test")
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
                    'price' => $food->getPrice());

                $jsonData[$idx++] = $temp;
            }


            return new JsonResponse($jsonData);
        } else {
            return $this->render('main/index.html.twig');
        }

    }

    /**
     * @Route("/collect", name="collect")
     * @param Request $request
     * @param OrderPicker $orderPicker
     * @return JsonResponse|Response
     */

    public function test(Request $request, OrderPicker $orderPicker)
    {

        $array = json_decode($_POST['array']);

        if ($request->isXmlHttpRequest()) {

            $orderPicker->insert($array);

            $this->saveOrder($orderPicker);

            return new Response();

        } else {
            return new Response('This is not ajax!', 400);

        }

    }

    public function saveOrder(OrderPicker $orderPicker)
    {
        $idArray = $orderPicker->select();
        $user = $this->getUser()->getUsername();

        $entityManager = $this->getDoctrine()->getManager();

        $Order = new FoodOrders();

        $Order->setUser($user);
        $Order->setProducts($idArray);
        $entityManager->persist($Order);
        $entityManager->flush();
        $this->addFlash('success', 'Zamówienie złożone!');

    }

    /**
     * @Route("/show", name="show")
     * @param Request $request
     * @param OrderPicker $orderPicker
     * @return JsonResponse|Response
     */

    public function show(Request $request)
    {

        if ($request->isXmlHttpRequest()) {

            $date = new \DateTime();

            $foods = $this->getDoctrine()
                ->getRepository(FoodOrders::class)->findBy([
                    'data'=>$date
                ]);
            $productsArray=array();
            $index=0;

            foreach($foods as $food) {
                $temp=array(
                    'foods' => $food->getProducts(),
                    'id'=>$food->getId(),
                    'name'=>$food->getUser()
                    );

                $productsArray[$index]=$temp;

            }
            return new JsonResponse($productsArray);

        } else {
            return $this->render('main/index.html.twig');
        }
    }
}

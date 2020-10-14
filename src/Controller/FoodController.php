<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\FoodAddType;
use App\Service\AddToOrder;
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
                'form' =>$form->createView()
            ]);


    }

    /**
     * @Route("/test", name="test")
     * @param Request $request
     * @param $id
     * @return JsonResponse|Response
     */

    public function ajaxAction(Request $request) {
        if ($request->isXmlHttpRequest()) {
        $data=$_POST['id'];



        $foods = $this->getDoctrine()
            ->getRepository(Food::class)
            ->findBy([
                'id'=>$data
            ]);

        $jsonData=array();
            $idx = 0;
        foreach ($foods as $food){
            $temp = array(
            'name'=> $food->getName(),
            'price' =>$food->getPrice());

            $jsonData[$idx++]=$temp;
        }

        return new JsonResponse($jsonData);




        } else {
            return $this->render('main/index.html.twig');
        }
    }

//    public function ajaxAction(Request $request)
//    {
//        $foods = $this->getDoctrine()
//            ->getRepository(Food::class)->findAll();
//
//        if ($request->isXmlHttpRequest() || $request->query->get('ShowJson')==1){
//            $jsonData =array();
//            $idx = 0;
//            foreach($foods as $food) {
//                $temp = array(
//                    'name' => $food->getName(),
//                    'price' => $food->getPrice(),
//                );
//                $jsonData[$idx++] = $temp;
//            }
//            return new JsonResponse($jsonData);
//        }
//        else{
//            return $this->render('main/index.html.twig');
//        }
//    }
}

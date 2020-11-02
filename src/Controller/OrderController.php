<?php

namespace App\Controller;




use App\Entity\Food;
use App\Entity\Orders;
use App\Form\OrderType;
use App\Repository\OrdersRepository;
use App\Service\FunctionCheck;
use Cassandra\Date;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Exception;
use http\Env\Response;
use PhpParser\Node\Stmt\Return_;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;




class OrderController extends AbstractController
    /**
     * @Route("{_locale}/order", name="order.")
     */
{


    /**
     * @Route("/order", name="order")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function order(Request $request)
    {

            $order = new Orders();
            $form = $this->createForm(OrderType::class, $order);

            $form->handleRequest($request);
            $username = $this->getUser()->getUsername();
            $order->setName($username);


            if ($form->isSubmitted()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($order);
                $em->flush();

                $this->addFlash('success', 'Zamówienie zostało dodane, dziękujemy!');
                return $this->redirect($this->generateUrl('index'));


            }


            return $this->render('order/index.html.twig', [
                'form' => $form->createView()
            ]);



    }

    /**
     * @Route("/details/{id}", name="details")
     * @param Orders $orders
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function details(Orders $orders){

        return $this->render('order/details.html.twig',[
            'orders' => $orders
        ]);

    }

    /**
     * @Route("/delete/single", name="delete_single")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteFromMadeOrder(Request $request)
    {

        if ($request->isXmlHttpRequest()) {

            $date = new DateTime;
            $user = $this->getUser()->getUsername();

            $id=$_POST['id'];
            $orders = $this->getDoctrine()
                ->getRepository(Orders::class)
                ->findBy([
                    'date'=>$date,
                    'user'=>$user,
                    'products_id'=>$id
                ]);

            $em = $this->getDoctrine()->getManager();

                $em->remove($orders);
                $em->flush();

            return new JsonResponse('Zamówienie zostało usunięte');
        }
    }


        /**
     * @Route("/delete/all", name="delete")
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteAllOrders(Request $request){

        if ($request->isXmlHttpRequest()) {
            $date = new DateTime;

            $user=$this->getUser()->getUsername();

        $orders=$this->getDoctrine()
            ->getRepository(Orders::class)
            ->findBy([
                'Name'=>$user,
                'Date'=>$date
            ]);
            $em= $this->getDoctrine()->getManager();
            foreach($orders as $order){
                $em->remove($order);
                $em->flush();
            }


            Return new JsonResponse('Zamówienie zostało usunięte');
    }

    }

    /**
     * @Route("/made", name="made")
     * @param Request $request
     * @return JsonResponse
     */
    public function showMadeOrders(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $date = new DateTime();
            $orders = $this->getDoctrine()->getRepository(Orders::class)->findBy(
                ['Date' => $date]);
            $company = $this->getDoctrine()->getRepository(Food::class);

            $ordersArray = array();
            $counter = -1;
            $userCounter=-1;
            $user = '';
            $userArray=array();

            $currentUser='';
            foreach ($orders as $order) {

                $food = $order->getProducts();
                $id=$order->getId();
                $company=$food->getCompany()->getName();

                $user=$order->getName();



                if($currentUser!=$user) {

                    $currentUser = $user;

                    $userArray = array(

                        'user' => $user,
                        'status' => $order->getStatus(),
                        'company'=>$company
                    );

                    $userCounter++;
                    $counter=0;
                }
                    $productsArray = array(

                    'price' => $food->getPrice(),
                    'product' => $food->getName(),
                    'id' => $id
                    );
                $userArray['products'][$counter]= $productsArray;


                $ordersArray[$userCounter] = $userArray;
                $counter++;
            }

            return new JsonResponse($ordersArray);


        } else {

        }

    }

    /**
     * @Route("/status", name="status")
     * @param Request $request
     * @return JsonResponse
     */
    public function changeStatus(Request $request){

        $date = new DateTime();

        $id=$_POST['id'];
        $status=$_POST['status'];
//        var_dump($status);
        if($request->isXmlHttpRequest()){

           $em= $this->getDoctrine()->getManager();
            $orders=$this->getDoctrine()->getRepository(Orders::class)
                ->findBy(['Name'=>$id,
                    'Date'=>$date]);

            foreach($orders as $order) {

                $order->setStatus($status);
                $em->persist($order);
                $em->flush();
            }

            Return new JsonResponse('Status zmieniony');

        }
        else{
            Return new JsonResponse('Wystąpił błąd');
        }
    }

//        /**
//         * @Route("/delete", name="delete")
//         * @param Request $request
//         * @return JsonResponse
//         */
//        public function editOrders(Request $request){
//
//            $order =$([])
//            if($request->isXmlHttpRequest()){
//
//
//                }
//
//                Return new JsonResponse();
//
//
//            }
//            else{
//
//            }
//    }

}

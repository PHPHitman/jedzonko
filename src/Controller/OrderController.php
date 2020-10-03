<?php

namespace App\Controller;




use App\Entity\Orders;
use App\Form\OrderType;
use App\Repository\OrdersRepository;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Exception;
use http\Env\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function order(Request $request)
    {
        $user = $this->getUser()->getUsername();
        $array = explode(' ', $user);
        $date = new \DateTime();
        $result = $date->format('Y-m-d');
        $array2 = explode(' ', $result);


        $repository = $this->getDoctrine()->getRepository(Orders::class);
        $orders = $repository->findBy(
            ['Name' => $array, 'Date' => $array2]
        );
        if(!$orders) {

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
        $this->addFlash('removed','Złożyłeś już dzisiaj zamówienie. Przejdź do zakładki Twoje Zamówienia w celu edycji');
        return $this->redirect($this->generateUrl('index'));
    }

    /**
     * @Route("/placed", name="placed")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws Exception
     */
    public function placed (){
        $user = $this->getUser()->getUsername();
        $array = explode(' ', $user);
        $date = new \DateTime();
        $result = $date->format('Y-m-d');
        $array2 = explode(' ', $result);


        $repository = $this->getDoctrine()->getRepository(Orders::class);
        $orders = $repository->findBy(
            ['Name' => $array, 'Date' => $array2]


        );


        return $this->render('order/details.html.twig',[
            'orders' => $orders
            ]);
    }
}

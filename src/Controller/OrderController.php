<?php

namespace App\Controller;




use App\Entity\Orders;
use App\Form\OrderType;
use App\Repository\OrdersRepository;
use App\Service\FunctionCheck;
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

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


class OrderController extends AbstractController
{
    /**
     * @Route("/order", name="order")
     * @param Request $request
     * @param FunctionCheck $functionCheck
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
     * @Route("/delete/{id}", name="delete")
     * @param Orders $orders
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(Orders $order){
        $em= $this->getDoctrine()->getManager();
        $em->remove($order);
        $em->flush();
        $this->addFlash('removed','Zamówienie zostało usunięte!');
        return $this->redirect($this->generateUrl('index'));

    }
}

<?php

namespace App\Controller;


use App\Entity\Company;
use App\Entity\Food;
use App\Entity\Orders;
use PhpParser\Node\Stmt\Return_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class CompanyController extends AbstractController
    /**
     * @Route("/{_locale}/company", name="company.")
     */
{
    /**
     * @Route("/add", name="add")
     * @param Request $request
     */
    public function addCompany(Request $request)
    {

        if ($request->isXmlHttpRequest()) {

            $companyName = $_POST['company'];
            $phone = $_POST['phone'];

            $em = $this->getDoctrine()->getManager();

            $Company = new Company();
            $Company->setName($companyName);
            $Company->setPhone($phone);

            $em->persist($Company);
            $em->flush();

            return new JsonResponse('Firma została dodana');

        }
        return new JsonResponse('Wystąpił błąd');

    }

    /**
     * @Route("/delete", name="delete")
     * @param Request $request
     */
    public function deleteCompany(Request $request)
    {

        if ($request->isXmlHttpRequest()) {





            }



        }


}

<?php

namespace App\Controller;

use App\Entity\Company;
use App\Entity\Food;
use App\Service\FoodDisplay;
use App\Service\FunctionCheck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

class MainController extends AbstractController
{
    /**
     * @Route(
     *     "/{_locale}/profile",
     *     name="index",
     *     requirements={
     *         "_locale": "en|fr|de|pl",
     *     }
     * )
     * @param Request $request
     * @param FunctionCheck $functionCheck
     * @param FoodDisplay $foodDisplay
     * @return Response
     */


    public function index(Request $request,FunctionCheck $functionCheck, FoodDisplay $foodDisplay)
    {
        $request->getSession()->set('_locale', 'pl');

        $companies =$this->getDoctrine()->getRepository(Company::class)
            ->findAll();


        return $this->render('main/index.html.twig',[
            'companies' => $companies
        ]);


    }

    /**
     * @Route(
     *     "/translation",
     *     name="translation",
     *     requirements={
     *         "_locale": "en|fr|de|pl",
     *     }
     * )
     * @param Request $request
     * @param FunctionCheck $functionCheck
     * @param FoodDisplay $foodDisplay
     * @return Response
     */
    public function translation(Request $request){
        {

            $locale = $request->getLocale();

            if($request->isXmlHttpRequest()){


            $file = __DIR__ . '/../../translations/messages.en.yaml';
            $parsed = Yaml::parse(file_get_contents($file));

            $translations = array(
                'json' => json_encode($parsed)
            );


            return new JsonResponse($translations);
        }}

    }


}

<?php


namespace App\Controller;


use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * @param PropertyRepository $repository
     * @return Response
     * @Route("/",name="home")
     */
    public function index(PropertyRepository $repository): Response
    {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig',[
            "properties"=>$properties
        ]);
    }
}
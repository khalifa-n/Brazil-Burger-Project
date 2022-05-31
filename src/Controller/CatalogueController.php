<?php

namespace App\Controller;

use App\Repository\BurgerRepository;
use App\Repository\ComplementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatalogueController extends AbstractController
{
    #[Route('/', name: 'app_catalogue')]
    public function index(ComplementRepository $complementRepository, BurgerRepository $burgerRepository,Request $request): Response
    {
        $burgers=$burgerRepository->findBy(['etat'=>'non-archiver']);
        $complements = $complementRepository->findAll();
        return $this->render('catalogue/catalogue.html.twig', [
            'controller_name' => 'CatalogueController',
            'burgers'=>$burgers,
            'complements'=>$complements,

        ]);
    } 

    #[Route('/catalogue/detail/{id}', name: 'app_detail_burger')]
    public function detail_burger(int $id, BurgerRepository $burgerRepository){
        $burgers=$burgerRepository->findBy(['id'=>$id]);  
        return $this->render('catalogue/detail.html.twig', [
            'controller_name' => 'CatalogueController',
            'burgers'=>$burgers,
        ]);
    } 
}

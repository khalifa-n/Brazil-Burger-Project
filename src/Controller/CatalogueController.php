<?php

namespace App\Controller;

use App\Entity\Burger;
use App\Repository\BurgerRepository;
use App\Repository\ComplementRepository;
use App\Repository\MenuRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatalogueController extends AbstractController
{
   
    #[Route('/', name: 'app_catalogue')]
    public function index(ComplementRepository $complementRepository, BurgerRepository $burgerRepository,MenuRepository $menuRepository): Response
    {
        $burgers=$burgerRepository->findBy(['etat'=>'non-archiver']);
        $complements = $complementRepository->findAll();
        $menus = $menuRepository->findBy(['etat'=>'non-archiver']);
        //dd($burgers);   
        return $this->render('catalogue/catalogue.html.twig', [
            'controller_name' => 'CatalogueController',
            'burgers'=>$burgers,
            'complements'=>$complements,
            'menus'=>$menus,
        

        ]);
    } 

    #[Route('/catalogue/detail/{id}', name: 'app_detail_burger')]
    public function detail_burger(int $id, BurgerRepository $burgerRepository,Burger $burger){
        $burgers=$burgerRepository->findBy(['id'=>$id]);  
        return $this->render('catalogue/detail.html.twig', [
            'controller_name' => 'CatalogueController',
            'burgers'=>$burgers,
        ]);
    } 
}

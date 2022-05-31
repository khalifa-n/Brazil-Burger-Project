<?php

namespace App\Controller;

use App\Entity\Menu;
use App\Entity\Image;
use App\Form\MenuType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController
{
    #[Route('/menu', name: 'app_menu')]
    public function add(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $menu = new Menu;
        $form = $this->createForm(MenuType::class,$menu);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $images = $form->get('image')->getData();
            foreach ($images as $image) {
                $fichier = md5(uniqid()). '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Image();
                $img->setNom($fichier);
                $menu->addImage($img);
            }
            
           // $menu=$form ->getData();
            $entityManagerInterface->persist($menu);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_catalogue');

        }
        return $this->render('menu/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}

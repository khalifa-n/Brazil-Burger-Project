<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Burger;
use App\Form\BurgerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BurgerController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
        
    }
    
    #[Route('/burger', name: 'list_burger')]
    public function list(): Response
    {
        $repository = $this->em->getRepository(Burger::class);
        $burgers=  $repository->findBy(['etat'=>'non-archiver']);
        return $this->render('burger/list.html.twig', [
            'controller_name' => 'BurgerController',
            'burgers'=>$burgers
        ]);
    }
     #[Route('/edit/{id}', name: 'edit_burger')]
    public function editBurger(Request $request)
    {
        $burger=new Burger();
        $form = $this->createForm(BurgerType::class,$burger);
        $form ->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('image')->getData();

            foreach($images as $image){
                $fichier=md5(uniqid()). '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Image();
                $img->setNom($fichier);
                $burger->addImage($img);
            }
            $burger = $form -> getData();
            $this-> em->persist($burger);
            $this-> em->flush();
            return $this->redirectToRoute('app_catalogue');
        }
        return $this->render('burger/add.html.twig', [
            'form' => $form->createView(),
        ]);

    }
    #[Route('/add', name: 'add_burger',methods:['GET','POST'])]
    public function addBurger(Request $request): Response
    {
        //dd($request);
       
        $burger = new Burger();
        $form = $this->createForm(BurgerType::class,$burger);
        $form->handleRequest($request) ;
        if ($form->isSubmitted() && $form->isValid()) {
            $images=$form->get('image')->getData();
            foreach ($images as $image) {
                $fichier = md5(uniqid()). '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Image();
                $img->setNom($fichier);
                $burger->addImage($img);
                
            }
            $burger=$form ->getData();
           $this-> em->persist($burger);
           $this-> em->flush();
           $this-> addFlash('success','votre produit a été ajouté avec succés');

            return $this->redirectToRoute('app_catalogue');
        }
        return $this->render('burger/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   

}

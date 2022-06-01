<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Complement;
use App\Form\ComplementType;
use App\Repository\ComplementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ComplementController extends AbstractController
{
    private $em;
   
    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }
    #[Route('/list_complement', name: 'list_complement')]
   
    public function list(): Response
    {
        $repository = $this->em->getRepository(Complement::class);
        $complements=  $repository->findBy(['etat'=>'non-archiver']);


        return $this->render('complement/list.html.twig', [
            'controller_name' => 'ComplementConétroller',
            'complements'=> $complements,
        ]);
    }
    #[Route('/complement', name: 'app_complement')]
    public function add(EntityManagerInterface $entityManagerInterface, Request $request ): Response
    {
        $complement = new Complement;
        $form = $this->createForm(ComplementType::class,$complement);
        $form = $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) { 
            $images = $form->get('image')->getData();
            foreach ($images as $image ) {
                $fichier = md5(uniqid()). '.' .$image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                $img = new Image();
                $img->setNom($fichier);
                $complement->addImage($img);
            }
            $complement=$form ->getData();
            $entityManagerInterface->persist($complement);
            $entityManagerInterface->flush();

            return $this->redirectToRoute('app_catalogue');

        }
        return $this->render('complement/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
   
}

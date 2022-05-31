<?php

namespace App\Controller;

use App\Repository\BurgerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class GestionnaireController extends AbstractController
{
    #[Route('/panier', name: 'app_panier')]
    public function index(SessionInterface $session,BurgerRepository $burgerRepository ,Request $request): Response
    {
        $method=$request->getMethod();
        $panier = $session->get('panier',[]);
        $panierwithdata =[];

        foreach ($panier as $id => $quantity) {
            $panierwithdata[] =[
                'burger' =>$burgerRepository->find($id),
                'quantity'=>$quantity
            ];
 
        }
        $total = 0;
        // dd($panier);
        foreach ($panierwithdata as $item) {
            $totalItem = $item['burger']->getPrix() * $item['quantity'];
            $total += $totalItem;
        }
        // $commande= new Commande();
        // if ($method=='POST') {
        //     $commande->setDate(new\date);
        // }
        return $this->render('gestionnaire/index.html.twig', [
            'items' => $panierwithdata,
            'total' =>$total,
        ]);
    }

    #[Route('/panier/add/{id}', name: 'app_add_panier')]
    public function add($id, SessionInterface $session): Response
    {
        $panier = $session->get('panier',[]);
        if(!empty($panier[$id])) {
            $panier[$id]++;
        }else{
            $panier[$id]= 1;

        }
        $session->set('panier',$panier);
        //dd($session->get('panier'));
        return $this->redirectToRoute('app_panier'); 
    }

    #[Route('/panier/remove/{id}', name: 'app_remove_panier')]
    
    public function remove($id,SessionInterface $session): Response
    {
        $panier = $session->get('panier',[]);
        if (!empty($panier[$id])) {
           unset($panier[$id]);
        }
        $session->set('panier',$panier);
        return $this->redirectToRoute('app_panier');
    }
}

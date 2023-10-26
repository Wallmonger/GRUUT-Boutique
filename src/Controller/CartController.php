<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/mon-panier', name: 'app_cart')]

    public function index(Cart $cart): Response
    {
        return $this->render('cart/index.html.twig', [
            'cart' => $cart->getFull()
        ]);
    }



    #[Route('/cart/add/{id}', name: 'app_add_to_cart')]

    public function add(Cart $cart, $id, Request $request): Response
    {
        $cart->add($id);
        return $this->json([
            'code' => 200,
            'message' => 'bien ajouté',
            'quantity' => $cart->get($id)[$id]
        ], 200); 

        // dd($cart->get($id)[$id]);
        // return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/cart/addo/{id}', name: 'app_addo_to_cart')]

    public function addo(Cart $cart, $id, Request $request): Response
    {
        $cart->add($id);    
        return $this->redirect($request->headers->get('referer'));
    }


    #[Route('/cart/remove', name: 'app_remove_my_cart')]

    public function remove(Cart $cart): Response
    {
        $cart->remove();
        
        return $this->redirectToRoute('app_product');
    }

    
    #[Route('/cart/delete/{id}', name: 'app_delete_to_cart')]

    public function delete(Cart $cart, $id, Request $request): Response
    {
        $cart->delete($id);
        
        return $this->redirect($request->headers->get('referer'));
    }

    #[Route('/cart/decrease/{id}', name: 'app_decrease_to_cart')]

    public function decrease(Cart $cart, $id): Response
    {
        $cart->decrease($id);
        return $this->json([
            'code' => 200,
            'message' => 'bien ajouté',
            'quantity' => $cart->get($id)[$id]
        ], 200); 
        // return $this->redirectToRoute('app_cart');
    }

   
}

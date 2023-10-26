<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountOrderController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    // TOUTES MES COMMANDES ================================================= 

    #[Route('/compte/mes-commandes', name: 'app_account_order')]
    public function index(Cart $cart): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        
        
        return $this->render('account/order.html.twig', [
            'cart' => $cart,
            'orders' => $orders
        ]);
    }

    // MES COMMANDES PAYEES =============================================================

    #[Route('/compte/mes-commandes-payees', name: 'app_account_order_payees')]
    public function indexPaye(Cart $cart): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        
        
        return $this->render('account/bystate/order_payees.html.twig', [
            'cart' => $cart,
            'orders' => $orders
        ]);
    }

    // MES COMMANDES PREPARATION =============================================================

    #[Route('/compte/mes-commandes-preparation', name: 'app_account_order_preparation')]
    public function indexPreparation(Cart $cart): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        
        
        return $this->render('account/bystate/order_preparation.html.twig', [
            'cart' => $cart,
            'orders' => $orders
        ]);
    }

    // MES COMMANDES PAYEES =============================================================

    #[Route('/compte/mes-commandes-livraison', name: 'app_account_order_livraison')]
    public function indexLivraison(Cart $cart): Response
    {
        $orders = $this->entityManager->getRepository(Order::class)->findSuccessOrders($this->getUser());
        
        
        return $this->render('account/bystate/order_livraison.html.twig', [
            'cart' => $cart,
            'orders' => $orders
        ]);
    }

    // VISUALISATION DES COMMANDES

    #[Route('/compte/mes-commandes/{reference}', name: 'app_account_order_show')]
    public function show(Cart $cart, $reference): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_account_order');
        }
        
        return $this->render('account/order_show.html.twig', [
            'cart' => $cart,
            'order' => $order
        ]);
    }

    
}

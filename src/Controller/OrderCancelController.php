<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderCancelController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    #[Route('/commande/erreur/{stripSessionId}', name: 'app_order_cancel')]
    public function index($stripSessionId, Cart $cart): Response
    {

        $order = $this->entityManager->getRepository(Order::class)->findOneByStripSessionId($stripSessionId);

        if (!$order || $order->getUser() != $this->getUser() ) {           // N'accepte que la commande de l'utilisateur connecté, une url d'un autre utilisateur ne marchera pas
            return $this->redirectToRoute('app_home');                         // Si on essaie de taper au hasard un id, on est redirigé vers la home page
        }

        // Envoyer un email à notre utilisateur pour lui indiquer l'échec de paiement
        return $this->render('order_cancel/index.html.twig', [
            'order' => $order,
            'cart' => $cart
        ]);
    }
}

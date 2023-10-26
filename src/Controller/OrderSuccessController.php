<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Classe\Mail;
use App\Entity\AuthorizationAvis;
use App\Entity\Materials;
use App\Entity\MaterialsOfProduct;
use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Stripe\Issuing\Authorization;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderSuccessController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }

    #[Route('/commande/merci/{stripSessionId}', name: 'app_order_validate')]
    public function index($stripSessionId, Cart $cart): Response
    {
        $order = $this->entityManager->getRepository(Order::class)->findOneByStripSessionId($stripSessionId);

        if (!$order || $order->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

            // Insert product authorization
            
            
            // dd($carte['product']);
    
        
        

        if (!$order->getState()) {
            
            $carte = $cart->getFull();    
            $cartLength = count($carte);
            for ($i = 0; $i < $cartLength; $i++) {
                $AuthorizationEntity = new AuthorizationAvis;

                $productCart = $carte[$i]['product'];
                $userCart = $this->getUser();
                $AuthorizationEntity->setProduct($productCart);
                $AuthorizationEntity->setUser($userCart);
                $AuthorizationEntity->setIsAllowed(true);
                $this->entityManager->persist($AuthorizationEntity);
                $this->entityManager->flush();
               
            }
            // ========================================================
            // SUPPRESSION DES MATERIAUX DANS LES STOCKS
            foreach ($cart->getFull() as $product) {    
                
                $materialsOfProduct = $this->entityManager->getRepository(MaterialsOfProduct::class)->findMyMaterials($product['product']);
                foreach ($materialsOfProduct as $marto) {
                
                    $leMateriau = $marto->getMaterial();
                    $locationMateriau = $this->entityManager->getRepository(Materials::class)->findOneById($leMateriau->getId());               
                    $locationMateriau->setQuantity((($locationMateriau->getQuantity()) - (($product['quantity']) * $marto->getQuantity())));
                    
                }
                
            }
            // ======================================================

            // Lorsque le paiement est accepté, il faut vider le panier donc : 
            $cart->remove();

            // On met le paiement en 1 car il est payé
            $order->setState(1);
            $this->entityManager->flush();

            // Envoyer un mail pour confirmer sa commande

            $mail = new Mail();
            $content = "Bonjour".$order->getUser()->getFirstname()."<br\> Merci pour votre commande";
            $mail->send($order->getUser()->getEmail(), $order->getUser()->getFirstname(), 'Votre commande Gruut a bien été validée', $content);
        }

        return $this->render('order_success/index.html.twig', [
            'order' => $order,
            'cart' => $cart
        ]);
    }
}

<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Entity\AuthorizationAvis;
use App\Entity\Order;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;

class StripeController extends AbstractController
{
    #[Route('/commande/create-session/{reference}', name: 'stripe_create_session')]
    public function index(EntityManagerInterface $entityManager, Cart $cart, $reference): Response
    {
        $products_for_stripe= [];
        $YOUR_DOMAIN = getenv(url);

        $order = $entityManager->getRepository(Order::class)->findOneByReference($reference);

        if (!$order) {
          $response = new JsonResponse(['error' => 'order']);
        }

        foreach ($order->getorderDetails()->getValues() as $product) {
            $product_object = $entityManager->getRepository(Product::class)->findOneByName($product->getProduct());
            $products_for_stripe[] = [
                'price_data' => [
                  'currency' => 'eur',
                  'product_data' => [
                    'name' => $product->getProduct(),
                    'images' => [$YOUR_DOMAIN."/assets/img/uploads/".$product_object->getIllustration()]
                  ],
                  'unit_amount' => $product->getPrice(),
                ],
                'quantity' => $product->getQuantity(),
          ];
        }

        $products_for_stripe[] = [
          'price_data' => [
            'currency' => 'eur',
            'product_data' => [
              'name' => $order->getCarrierName(),
              'images' => [$YOUR_DOMAIN],
            ],
            'unit_amount' => $order->getCarrierPrice(),
          ],
          'quantity' => 1,
    ];

        Stripe::setApiKey(getenv(stripeapikey));
            
        $checkout_session = Session::create([
            'customer_email' => $this->getUser()->getEmail(),
            'payment_method_types' => ['card'],
            'line_items' => [
                $products_for_stripe
              ],
            'mode' => 'payment',
            'success_url' => 'url/commande/merci/{CHECKOUT_SESSION_ID}',
            'cancel_url' => 'url/commande/erreur/{CHECKOUT_SESSION_ID}',
          ]);

        header("see other");
        header("Location: " . $checkout_session->url);

        $order->setStripSessionId($checkout_session->id);
      
        $entityManager->flush();

        $response = new JsonResponse(['id' => $checkout_session->id]);
        return $response;
    }
}